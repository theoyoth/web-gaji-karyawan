<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\Awak12Export;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
  public function create(Request $request){
    if($request->input("from") === 'kantor 1'){
      $kantor = "kantor 1";
    } else {
      $kantor = "kantor 2";
    }

    $employees = Employee::whereIn('kantor', [$kantor])
             ->with('salaries')
             ->get();
		return view('employee.create-kantor',compact('employees'));
	}

	public function createAwak12(){
    $kantor = ["awak 1 dan awak 2"];
    $employees = Employee::whereIn('kantor', $kantor)
             ->with('salaries')
             ->get();

    return view('employee.create-awak12', compact('employees'));
	}

	public function store(Request $request){
		$request->validate([
			'nama' => 'max:255',
			'kantor' => 'required|max:255',
			'tempat_lahir' => 'nullable|string',
			'tanggal_lahir' => 'nullable|date',
			'tanggal_masuk' => 'nullable|string',

			'gaji_pokok' => 'required|numeric',
			'hari_kerja' => 'required|numeric',
			'bulan' => 'required',
			'tahun' => 'required|digits:4|integer|min:2010|max:'. date('Y'),

			'tunjangan_makan' => 'nullable|numeric',
			'tunjangan_hari_tua' => 'nullable|numeric',

			'potongan_bpjs' => 'required|numeric',
			'potongan_tabungan_hari_tua' => 'nullable|numeric',
			'potongan_kredit_kasbon' => 'required|numeric',

			'ttd' => 'nullable|string',
      'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
		]);

		// store image in storage folder
		// Clean the base64 signature
		$imageData = $request->input('ttd');
		$image = str_replace('data:image/png;base64,', '', $imageData);
		$image = str_replace(' ', '+', $image);

		// Create unique filename
		$fileName = Str::title($request->input('nama')) . '.png';

		// Store file in storage/app/public/signatures
		Storage::disk('public')->put('ttd/' . $fileName, base64_decode($image));

		// calculated early the jumlah_gaji
		$jumlah_gaji = $request->gaji_pokok
		+ ($request->tunjangan_makan ?? 0)
		+ ($request->tunjangan_hari_tua ?? 0);

    if ($request->filled('employee_id') &&
        Salary::where('employee_id', $request->employee_id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->exists()) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Karyawan ini sudah terdaftar pada bulan ' . $request->bulan . ' tahun ' . $request->tahun);
    }
    else if ($request->filled('employee_id')) {
        $employee = Employee::find($request->employee_id);
    } else {
        if ($request->hasFile('foto_profil')) {
          $fotoPath = $request->file('foto_profil')->store('foto_profil', 'public');
        }
        else{
          $fotoPath = '';
        }

        $employee = new Employee();
        $employee->nama = Str::title($request->input('nama'));
        $employee->kantor = $request->input('kantor');
        $employee->tempat_lahir = Str::title($request->input('tempat_lahir')) ?: null;
        $employee->tanggal_lahir = $request->input('tanggal_lahir') ?: null;
        $employee->tanggal_masuk = $request->input('tanggal_masuk') ?: null;
        $employee->foto_profil = $fotoPath ?: null;
        $employee->save();
    }

		$salary = new Salary();

		$salary->employee_id = $employee->id;
		$salary->gaji_pokok = $request->input('gaji_pokok');
		$salary->hari_kerja = $request->input('hari_kerja');
		$salary->bulan = $request->input('bulan');
		$salary->tahun = $request->input('tahun');
		$salary->tunjangan_makan = $request->input('tunjangan_makan');
		$salary->tunjangan_hari_tua = $request->input('tunjangan_hari_tua') ?: 0;

		$salary->jumlah_gaji = $jumlah_gaji;

		$salary->potongan_bpjs = $request->input('potongan_bpjs');
		$salary->potongan_tabungan_hari_tua = $request->input('potongan_tabungan_hari_tua') ?: 0;
		$salary->potongan_kredit_kasbon = $request->input('potongan_kredit_kasbon');

		$salary->ttd = $fileName;

		$salary->save();
		$salary->refresh();

    // to count how many page for pagination
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

		$allEmployeesKantor1 = Employee::where('kantor', "kantor 1")
    ->whereHas('salaries', function ($q) use ($bulan, $tahun) {
        // Filter salaries by bulan (month) and tahun (year)
        if ($bulan && $tahun) {
            $q->where('bulan', $bulan)
              ->where('tahun', $tahun);
        }
    })->get()->count();

		$allEmployeesKantor2 = Employee::where('kantor', "kantor 2")
    ->whereHas('salaries', function ($q) use ($bulan, $tahun) {
        // Filter salaries by bulan (month) and tahun (year)
        if ($bulan && $tahun) {
            $q->where('bulan', $bulan)
              ->where('tahun', $tahun);
        }
    })->get()->count();

		$lastPageKantor1 = ceil($allEmployeesKantor1 / 15);
		$lastPageKantor2 = ceil($allEmployeesKantor2 / 15);

		if($employee->kantor === 'kantor 1'){
			return redirect()->route('filterbymonth.kantor',['bulan' => $request->input('bulan'), 'tahun' => $request->input('tahun'),'kantor' => $request->input('kantor'),'page'=>$lastPageKantor1])->with('success', 'employee saved successfully!');
		}
		else if($employee->kantor === 'kantor 2'){
			return redirect()->route('filterbymonth.kantor',['bulan' => $request->input('bulan'), 'tahun' => $request->input('tahun'),'kantor' => $request->input('kantor'),'page'=>$lastPageKantor2])->with('success', 'employee saved successfully!');
		}
		else{
			return redirect()->route('header.index')->with('success', 'employee saved successfully!');
		}

	}

	public function storeAwak12(Request $request){
		$request->validate([
      'employee_id' => 'nullable|exists:employees,id',
			'nama' => 'max:255',
			'kantor' => 'required|max:255',
      'tempat_lahir' => 'nullable|string',
			'tanggal_lahir' => 'nullable|date',
			'tanggal_masuk' => 'nullable|string',

			'gaji_pokok' => 'required|numeric',
			'hari_kerja' => 'required|numeric',
			'bulan' => 'required',
			'tahun' => 'required|digits:4|integer|min:2010|max:'. date('Y'),

			'tunjangan_makan' => 'nullable|numeric',

			'potongan_bpjs' => 'required|numeric',
			'potongan_tabungan_hari_tua' => 'nullable|numeric',
			'potongan_kredit_kasbon' => 'required|numeric',
			// delivery validation array
			'deliveries' => 'required|array|min:1',
			'deliveries.*.kota' => 'required|string',
			'deliveries.*.jumlah_retase' => 'required|numeric',
			'deliveries.*.tarif_retase' => 'required|numeric',

			'ttd' => 'nullable|string',
      'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

		]);

    // 🔍 Check if salary already exists for this employee in the same month + year
    $existingEmployee = null;

    if ($request->filled('employee_id')) {
        $existingEmployee = Employee::find($request->employee_id);
    } else {
        $existingEmployee = Employee::where('nama', Str::title($request->nama))
            ->where('kantor', $request->kantor)
            ->first();
    }

    if ($existingEmployee) {
        $alreadyExists = Salary::where('employee_id', $existingEmployee->id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->exists();

        if ($alreadyExists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Awak ini sudah terdaftar pada bulan ' . $request->bulan . ' tahun ' . $request->tahun);
        }
    }

		// store image in storage folder
		// Clean the base64 signature
		$imageData = $request->input('ttd');
		$image = str_replace('data:image/png;base64,', '', $imageData);
		$image = str_replace(' ', '+', $image);

		// Create unique filename
		$fileName = Str::title($request->input('nama')) . '.png';

		// Store file in storage/app/public/signatures
		Storage::disk('public')->put('ttd/' . $fileName, base64_decode($image));

    // create new instance for employee,salary,delivery
    // get or create employee
    if ($request->filled('employee_id')) {
        $employee = Employee::find($request->employee_id);
    } else {
        // create new instance for employee,salary,delivery
        if ($request->hasFile('foto_profil')) {
          $fotoPath = $request->file('foto_profil')->store('foto_profil', 'public');
        }
        else{
          $fotoPath = '';
        }

        $employee = new Employee();
        $employee->nama = Str::title($request->input('nama'));
        $employee->kantor = $request->input('kantor');
        $employee->tanggal_masuk = $request->input('tanggal_masuk') ?: null;
        $employee->foto_profil = $fotoPath ?: null;
        $employee->save();
    }

		$salary = new Salary();

		$salary->employee_id = $employee->id;
		$salary->gaji_pokok = $request->input('gaji_pokok');
		$salary->hari_kerja = $request->input('hari_kerja');
		$salary->bulan = $request->input('bulan');
		$salary->tahun = $request->input('tahun');
		$salary->tunjangan_makan = $request->input('tunjangan_makan');
		$salary->tunjangan_hari_tua = $request->input('tunjangan_hari_tua') ?: 0;

		$salary->jumlah_gaji = 0;

		$salary->potongan_bpjs = $request->input('potongan_bpjs');
		$salary->potongan_tabungan_hari_tua = $request->input('potongan_tabungan_hari_tua') ?: 0;
		$salary->potongan_kredit_kasbon = $request->input('potongan_kredit_kasbon');

    $salary->ttd = $fileName;

		$salary->save();
		$salary->refresh();

		// 4. Save multiple deliveries
		foreach ($request->input('deliveries', []) as $inputDelivery) {
			$delivery = new Delivery();

			$delivery->salary_id = $salary->id;
			$delivery->kota = $inputDelivery['kota'];
			$delivery->jumlah_retase = $inputDelivery['jumlah_retase'];
			$delivery->tarif_retase = $inputDelivery['tarif_retase'];

			$delivery->save();
		}

		 // Reload deliveries relation to access them
		$salary->load('deliveries');

		// Calculate total gaji
		$salary->jumlah_gaji = $salary->gaji_pokok
			+ $salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase)
			+ ($salary->tunjangan_makan ?? 0)
			+ ($salary->tunjangan_hari_tua ?? 0);

		$salary->save(); // Save the updated jumlah_gaji

    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

		$allEmployees = Employee::where('kantor', 'awak 1 dan awak 2') // Filter by kantor
    ->whereHas('salary', function ($q) use ($bulan, $tahun) {
        // Filter salaries by bulan (month) and tahun (year)
        if ($bulan && $tahun) {
            $q->where('bulan', $bulan)
              ->where('tahun', $tahun);
        }
    })->get()->count();

		$lastPage = ceil($allEmployees / 15);

		return redirect()->route('awak12.index',['bulan' => $bulan, 'tahun' => $tahun, 'page' => $lastPage])->with('success', 'employee saved successfully!');
	}

	public function destroy($id){
		$employee = Employee::with('salary')->findOrFail($id);

		// Loop through each salary associated with the employee
    // ✅ Delete signature (ttd)
		if ($employee->salary) {
			// $fileName = Str::title($employee->nama) . '.png'; // using capital first letter employee's name for the signature
			// $path = 'ttd/' . $fileName;

			// if (Storage::disk('public')->exists($path)) {
			// 	// Delete the file
			// 	Storage::disk('public')->delete($path);
			// }

			// Optionally delete the salary record if needed
			$employee->salary->delete();
		}

     // ✅ Delete foto_profil if exists
    // if ($employee->foto_profil) {
    //     $photoPath = $employee->foto_profil;
    //     if (Storage::disk('public')->exists($photoPath)) {
    //         Storage::disk('public')->delete($photoPath);
    //     }
    // }

		// Delete the employee
		// $employee->salary->delete();

		return redirect()->back()->with('success', 'employee deleted successfully.');
	}

	public function editPageAwak12($employeeId, $employeeSalaryId){
    $employee = Employee::findOrFail($employeeId);

    $salary = $employee->salary()
        ->with('deliveries')
        ->where('id', $employeeSalaryId)
        ->firstOrFail();

		return view('edit.awak12', compact('employee','salary'));
	}
	public function editPageKantor($employeeId,$employeeSalaryId){
    $employee = Employee::findOrFail($employeeId);

    $salary = $employee->salary()
        ->with('deliveries')
        ->where('id', $employeeSalaryId)
        ->firstOrFail();

		return view('edit.kantor', compact('employee','salary'));
	}

	public function updateAwak12(Request $request, $employeeId){
		$employee = Employee::with('salary.deliveries')->findOrFail($employeeId);

    if ($request->input('hapus_foto') == '1' && $employee->foto_profil) {
        Storage::disk('public')->delete($employee->foto_profil);
        $employee->foto_profil = null;
    }

     // Handle file upload if exists
    if ($request->hasFile('foto_profil')) {
        // Delete old photo if exists
        if ($employee->foto_profil && Storage::disk('public')->exists($employee->foto_profil)) {
            Storage::disk('public')->delete($employee->foto_profil);
        }

        // Store new photo
        $path = $request->file('foto_profil')->store('foto_profil', 'public');
        $employee->foto_profil = $path;
    }

    $employee->tanggal_masuk = $request->input('tanggal_masuk', $employee->tanggal_masuk);

    // Validate employee data
    $employee->update([
        'nama' => $request->nama,
        'kantor' => $request->kantor,
        'tanggal_masuk' => $request->tanggal_masuk,
    ]);

    $employee->save();

		// Update salary
		$salary = $employee->salary;

		$salary->gaji_pokok = $request->input('gaji_pokok', $salary->gaji_pokok);
		$salary->bulan = $request->input('bulan', $salary->bulan);
		$salary->tahun = $request->input('tahun', $salary->tahun);
		$salary->hari_kerja = $request->input('hari_kerja', $salary->hari_kerja);
		$salary->tunjangan_makan = $request->input('tunjangan_makan', $salary->tunjangan_makan);
		$salary->potongan_bpjs = $request->input('potongan_bpjs', $salary->potongan_bpjs);
		$salary->potongan_tabungan_hari_tua = $request->input('potongan_tabungan_hari_tua', ($salary->potongan_tabungan_hari_tua ?: 0));
		$salary->potongan_kredit_kasbon = $request->input('potongan_kredit_kasbon', $salary->potongan_kredit_kasbon);

		if ($request->input('delete_ttd') === '1') {
			// Delete old signature file
			if ($salary->ttd && Storage::disk('public')->exists('ttd/' . $salary->ttd)) {
				Storage::disk('public')->delete('ttd/' . $salary->ttd);
			}
			$salary->ttd = ' '; // Clear from DB
		} elseif($request->filled('ttd')) {
			$oldSignature = $salary->ttd;
			$imageData = $request->input('ttd');

			// Clean and decode base64 image
			$imageData = str_replace('data:image/png;base64,', '', $imageData);
			$imageData = str_replace(' ', '+', $imageData);
			$fileName = Str::title($employee->nama) . '.png';

			// Delete old signature file if different
			if ($oldSignature && Storage::disk('public')->exists('ttd/' . $oldSignature)) {
				Storage::disk('public')->delete('ttd/' . $oldSignature);
			}

			// Save new signature
			Storage::disk('public')->put('ttd/' . $fileName, base64_decode($imageData));

			// Update the database with the new signature file name
			$salary->ttd = $fileName;

		}
    // Delete old deliveries
		$salary->deliveries()->delete();

		// Add new deliveries
		if ($request->has('deliveries')) {
			foreach ($request->input('deliveries',[]) as $deliveryData) {
				$salary->deliveries()->create([
					'kota' => $deliveryData['kota'],
					'jumlah_retase' => $deliveryData['jumlah_retase'],
					'tarif_retase' => $deliveryData['tarif_retase'],
				]);
			}
		}

		// Reload deliveries relation to access them
		$salary->load('deliveries');

		// Calculate total gaji
		$salary->jumlah_gaji = $salary->gaji_pokok
			+ $salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase)
			+ ($salary->tunjangan_makan ?? 0)
			+ ($salary->tunjangan_hari_tua ?? 0);

    $salary->save();

    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

		return redirect()->route('awak12.index',['bulan' => $bulan, 'tahun' => $tahun, 'page' => $request->page])->with('success', 'employee updated successfully!');
	}

	public function updateKantor(Request $request, $employeeId){
	  $employee = Employee::with('salary')->findOrFail($employeeId);

    if ($request->input('hapus_foto') == '1' && $employee->foto_profil) {
        Storage::disk('public')->delete($employee->foto_profil);
        $employee->foto_profil = null;
    }
    // Handle file upload if exists
    if ($request->hasFile('foto_profil')) {
      // Delete old photo if exists
      if ($employee->foto_profil && Storage::disk('public')->exists($employee->foto_profil)) {
        Storage::disk('public')->delete($employee->foto_profil);
      }

      // Store new photo
      $path = $request->file('foto_profil')->store('foto_profil', 'public');
      $employee->foto_profil = $path;
    }

    $employee->tanggal_masuk = $request->input('tanggal_masuk', $employee->tanggal_masuk);

    // Validate employee data
    $employee->update([
        'nama' => $request->nama,
        'kantor' => $request->kantor,
        'tanggal_masuk' => $request->tanggal_masuk,
    ]);

    $employee->save();

	  // Update salary
	  $salary = $employee->salary;

	  $salary->gaji_pokok = $request->input('gaji_pokok', $salary->gaji_pokok);
	  $salary->bulan = $request->input('bulan', $salary->bulan);
	  $salary->tahun = $request->input('tahun', $salary->tahun);
	  $salary->hari_kerja = $request->input('hari_kerja', $salary->hari_kerja);
	  $salary->tunjangan_makan = $request->input('tunjangan_makan', $salary->tunjangan_makan);
	  $salary->potongan_bpjs = $request->input('potongan_bpjs', $salary->potongan_bpjs);
	  $salary->potongan_tabungan_hari_tua = $request->input('potongan_tabungan_hari_tua', ($salary->potongan_tabungan_hari_tua ?: 0));
	  $salary->potongan_kredit_kasbon = $request->input('potongan_kredit_kasbon', $salary->potongan_kredit_kasbon);

	  if ($request->input('delete_ttd') === '1') {
		// Delete old signature file
		if ($salary->ttd && Storage::disk('public')->exists('ttd/' . $salary->ttd)) {
			Storage::disk('public')->delete('ttd/' . $salary->ttd);
      }
      $salary->ttd = ' '; // Clear from DB
		} elseif($request->filled('ttd')) {
		  $oldSignature = $salary->ttd;
		  $imageData = $request->input('ttd');

		  // Clean and decode base64 image
		  $imageData = str_replace('data:image/png;base64,', '', $request->input('ttd'));
		  $imageData = str_replace(' ', '+', $imageData);
		  $fileName = Str::title($employee->nama) . '.png';

		  // Delete old signature file if different
		  if ($oldSignature && Storage::disk('public')->exists('ttd/' . $oldSignature)) {
			  Storage::disk('public')->delete('ttd/' . $oldSignature);
		  }

		  // Save new signature
		  Storage::disk('public')->put('ttd/' . $fileName, base64_decode($imageData));

		  $salary->ttd = $fileName;
	  }

	  // Calculate jumlah gaji
	  $salary->jumlah_gaji = $salary->gaji_pokok
		  + ($salary->tunjangan_makan ?? 0)
		  + ($salary->tunjangan_hari_tua ?? 0);

    $salary->save();

	  $page = $request->input('page', 1);

	  if($request->input('kantor') === 'kantor 1'){
		  return redirect()->route('filterbymonth.kantor',['bulan' => $request->input('bulan'), 'tahun' => $request->input('tahun'),'kantor' => $request->input('kantor'), 'page'=>$page])->with('success', 'employee updated successfully!');
	  }
	  else if($request->input('kantor') === 'kantor 2'){
		  return redirect()->route('filterbymonth.kantor',['bulan' => $request->input('bulan'), 'tahun' => $request->input('tahun'),'kantor' => $request->input('kantor'),'page'=>$page])->with('success', 'employee updated successfully!');
	  }
	}

  public function searchEmployeeAwak12(Request $request){
    $search = $request->input('search'); // Get search term from the request
    $month = $request->input('bulan');
    $year = $request->input('tahun');

    $employees = Employee::where('kantor', 'awak 1 dan awak 2')
    ->when($search, function ($query, $search) {
        $query->where('nama', 'like', '%' . $search . '%');
    })
    ->when($month && $year, function ($query) use ($month, $year) {
        $query->whereHas('salary', function ($q) use ($month, $year) {
            $q->where('bulan', $month)
              ->where('tahun', $year);
        });
    })
    ->with(['salary' => function ($q) use ($month, $year) {
        if ($month && $year) {
            $q->where('bulan', $month)
              ->where('tahun', $year);
        }
    }]);

    // Clone for total calculation (all data)
    $allEmployees = (clone $employees)->get();

    // Paginate data
    $employeesPaginate = $employees->paginate(15)->appends($request->only(['search']));  // Include search in pagination links

    // Calculate totals
    $totalEmployeesSalary = $allEmployees->reduce(function ($totalValue, $employee) {
      $salary = $employee->salary;

      return [
        'totalGajiPokok' => $totalValue['totalGajiPokok'] + ($salary->jumlah_gaji ?? 0),
        'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
        'totalJumlahRetase' => $totalValue['totalJumlahRetase'] + ($salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase) ?? 0),
        'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
        'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
        'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
        'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
        'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
      ];
    }, ['totalGajiPokok' => 0,'totalJumlahGaji' => 0, 'totalJumlahRetase' => 0, 'totalTunjanganMakan' => 0, 'totalPotonganBpjs' => 0, 'totalPotonganHariTua' => 0, 'totalPotonganKreditKasbon' => 0, 'totalGeneral' => 0]);

    // Calculate paginate employees total
    $pageTotals = $employeesPaginate->reduce(function ($totalValue, $employee) {
      $salary = $employee->salary;

      return [
        'totalGajiPokok' => $totalValue['totalGajiPokok'] + ($salary->jumlah_gaji ?? 0),
        'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
        'totalJumlahRetase' => $totalValue['totalJumlahRetase'] + ($salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase) ?? 0),
        'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
        'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
        'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
        'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
        'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
      ];
    }, ['totalGajiPokok' => 0,'totalJumlahGaji' => 0, 'totalJumlahRetase' => 0, 'totalTunjanganMakan' => 0, 'totalPotonganBpjs' => 0, 'totalPotonganHariTua' => 0, 'totalPotonganKreditKasbon' => 0, 'totalGeneral' => 0]);

    // Return view with the necessary data
    return view('place.awak12', [
      'employees' => $employeesPaginate,
      'pageTotals' => $pageTotals,
      'totalEmployeesSalary' => $totalEmployeesSalary,
    ]);
  }

  public function searchEmployeeKantor(Request $request){
    $search = $request->input('search'); // Get search term from the request
    $kantor = $request->input('kantor');
    $month = $request->input('bulan');
    $year = $request->input('tahun');

    $employees = Employee::where('kantor', $kantor) // Filter by kantor (if needed)
                  ->when($search, function ($query, $search) {
                    // If there's a search term, filter by the employee's name
                    return $query->where('nama', 'like', '%' . $search . '%');
                  })->with('salary');

    $employees = Employee::where('kantor', $kantor)
    ->when($search, function ($query, $search) {
        $query->where('nama', 'like', '%' . $search . '%');
    })
    ->when($month && $year, function ($query) use ($month, $year) {
        $query->whereHas('salary', function ($q) use ($month, $year) {
            $q->where('bulan', $month)
              ->where('tahun', $year);
        });
    })
    ->with(['salary' => function ($q) use ($month, $year) {
        if ($month && $year) {
            $q->where('bulan', $month)
              ->where('tahun', $year);
        }
    }]);

    // Clone for total calculation (all data)
    $allEmployees = (clone $employees)->get();

    // Paginate data
    $employeesPaginate = $employees->paginate(15)->appends($request->only(['search']));  // Include search in pagination links

    // Calculate totals
    $totalEmployeesSalary = $allEmployees->reduce(function ($totalValue, $employee) {
      $salary = $employee->salary;

      return [
        'totalGajiPokok' => $totalValue['totalGajiPokok'] + ($salary->jumlah_gaji ?? 0),
        'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
        'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
        'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
        'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
        'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
        'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
      ];
    }, ['totalGajiPokok' => 0, 'totalJumlahGaji' => 0, 'totalTunjanganMakan' => 0, 'totalPotonganBpjs' => 0, 'totalPotonganHariTua' => 0, 'totalPotonganKreditKasbon' => 0, 'totalGeneral' => 0]);

    // Calculate paginate employees total
    $pageTotals = $employeesPaginate->reduce(function ($totalValue, $employee) {
      $salary = $employee->salary;

      return [
        'totalGajiPokok' => $totalValue['totalGajiPokok'] + ($salary->jumlah_gaji ?? 0),
        'totalJumlahGaji' => $totalValue['totalJumlahGaji'] + ($salary->jumlah_gaji ?? 0),
        'totalTunjanganMakan' => $totalValue['totalTunjanganMakan'] + ($salary->tunjangan_makan ?? 0),
        'totalPotonganBpjs' => $totalValue['totalPotonganBpjs'] + ($salary->potongan_bpjs ?? 0),
        'totalPotonganHariTua' => $totalValue['totalPotonganHariTua'] + ($salary->potongan_hari_tua ?? 0),
        'totalPotonganKreditKasbon' => $totalValue['totalPotonganKreditKasbon'] + ($salary->potongan_kredit_kasbon ?? 0),
        'totalGeneral' => $totalValue['totalGeneral'] + ($salary->jumlah_gaji - ($salary->potongan_bpjs + $salary->potongan_hari_tua + $salary->potongan_kredit_kasbon) ?? 0),
      ];
    }, ['totalGajiPokok' => 0, 'totalJumlahGaji' => 0, 'totalTunjanganMakan' => 0, 'totalPotonganBpjs' => 0, 'totalPotonganHariTua' => 0, 'totalPotonganKreditKasbon' => 0, 'totalGeneral' => 0]);

    // Return view with the necessary data
    if($kantor == 'kantor 1'){
      return view('place.kantor1', [
        'employees' => $employeesPaginate,
        'pageTotals' => $pageTotals,
        'totalEmployeesSalary' => $totalEmployeesSalary,
      ]);
    }
    elseif($kantor == 'kantor 2'){
      return view('place.kantor2', [
        'employees' => $employeesPaginate,
        'pageTotals' => $pageTotals,
        'totalEmployeesSalary' => $totalEmployeesSalary,
      ]);
    }
  }

  public function exportAwak12(Request $request)
  {
    $month = $request->input('bulan');
    $year = $request->input('tahun');

    return Excel::download(new Awak12Export($month, $year), "awak12_{$month}_{$year}.xlsx");
  }
}
