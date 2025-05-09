<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Salary;
use App\Models\User;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
	public function create(){
		return view('user.create-kantor');
	}

	public function createAwak12(){
		return view('user.create-awak12');
	}

	public function store(Request $request){
		$request->validate([
			'nama' => 'required|max:255',
			'kantor' => 'required|max:255',
			'tempat_lahir' => 'nullable|string',
			'tanggal_lahir' => 'nullable|date',
			'tanggal_diangkat' => 'nullable|date',

			'gaji_pokok' => 'required|numeric',
			'hari_kerja' => 'required|numeric',
			'bulan' => 'required',
			'tahun' => 'required|digits:4|integer|min:2010|max:'. date('Y'),

			'tunjangan_makan' => 'nullable|numeric',
			'tunjangan_hari_tua' => 'nullable|numeric',

			'potongan_bpjs' => 'required|numeric',
			'potongan_tabungan_hari_tua' => 'required|numeric',
			'potongan_kredit_kasbon' => 'required|numeric',

			'ttd' => 'nullable|string',
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

		// create new instance for user,salary,delivery
		$user = new User();
		$salary = new Salary();


		// input data
		$user->nama = Str::title($request->input('nama'));
		$user->kantor = $request->input('kantor');
		$user->tempat_lahir = Str::title($request->input('tempat_lahir')) ?: null;
		$user->tanggal_lahir = $request->input('tanggal_lahir') ?: null;
		$user->tanggal_diangkat = $request->input('tanggal_diangkat') ?: null;

		$user->save();

		$salary->user_id = $user->id;
		$salary->gaji_pokok = $request->input('gaji_pokok');
		$salary->hari_kerja = $request->input('hari_kerja');
		$salary->bulan = $request->input('bulan');
		$salary->tahun = $request->input('tahun');
		$salary->tunjangan_makan = $request->input('tunjangan_makan');
		$salary->tunjangan_hari_tua = $request->input('tunjangan_hari_tua') ?? 0;

		$salary->jumlah_gaji = $jumlah_gaji;

		$salary->potongan_bpjs = $request->input('potongan_bpjs');
		$salary->potongan_tabungan_hari_tua = $request->input('potongan_tabungan_hari_tua');
		$salary->potongan_kredit_kasbon = $request->input('potongan_kredit_kasbon');

		$salary->ttd = $fileName;

		$salary->save();
		$salary->refresh();

		$allUsersKantor1 = User::where('kantor', "kantor 1")->get()->count();
		$allUsersKantor2 = User::where('kantor', "kantor 2")->get()->count();
		$lastPageKantor1 = ceil($allUsersKantor1 / 15);
		$lastPageKantor2 = ceil($allUsersKantor2 / 15);

		if($user->kantor === 'kantor 1'){
			return redirect()->route('kantor1.index',['page'=>$lastPageKantor1])->with('success', 'user saved successfully!');
		}
		else if($user->kantor === 'kantor 2'){
			return redirect()->route('kantor2.index',['page'=>$lastPageKantor2])->with('success', 'user saved successfully!');
		}
		else{
			return redirect()->route('header.index')->with('success', 'user saved successfully!');
		}

	}

	public function storeAwak12(Request $request){
		$request->validate([
			'nama' => 'required|max:255',
			'kantor' => 'required|max:255',

			'gaji_pokok' => 'required|numeric',
			'hari_kerja' => 'required|numeric',
			'bulan' => 'required',
			'tahun' => 'required|digits:4|integer|min:2010|max:'. date('Y'),

			'tunjangan_makan' => 'nullable|numeric',

			'potongan_bpjs' => 'required|numeric',
			'potongan_tabungan_hari_tua' => 'required|numeric',
			'potongan_kredit_kasbon' => 'required|numeric',
			// delivery validation array
			'deliveries' => 'required|array|min:1',
			'deliveries.*.kota' => 'required|string',
			'deliveries.*.jumlah_retase' => 'required|numeric',
			'deliveries.*.tarif_retase' => 'required|numeric',

			'ttd' => 'nullable|string',

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

		// create new instance for user,salary,delivery
		$user = new User();
		$salary = new Salary();

		// input data
		$user->nama = Str::title($request->input('nama'));
		$user->kantor = $request->input('kantor');

		$user->save();

		$salary->user_id = $user->id;
		$salary->gaji_pokok = $request->input('gaji_pokok');
		$salary->hari_kerja = $request->input('hari_kerja');
		$salary->bulan = $request->input('bulan');
		$salary->tahun = $request->input('tahun');
		$salary->tunjangan_makan = $request->input('tunjangan_makan');
		$salary->tunjangan_hari_tua = $request->input('tunjangan_hari_tua') ?: 0;

		$salary->jumlah_gaji = 0;

		$salary->potongan_bpjs = $request->input('potongan_bpjs');
		$salary->potongan_tabungan_hari_tua = $request->input('potongan_tabungan_hari_tua');
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

		$allUsers = User::where('kantor', "awak 1 dan awak 2")->get()->count();
		$lastPage = ceil($allUsers / 15);

		return redirect()->route('awak12.index',['page' => $lastPage])->with('success', 'user saved successfully!');
	}

	public function destroy($id){
		$user = User::with('salary')->findOrFail($id);

		// Loop through each salary associated with the user
		if ($user->salary) {
			$fileName = Str::title($user->nama) . '.png'; // using capital first letter user's name for the signature
			$path = 'ttd/' . $fileName;

			if (Storage::disk('public')->exists($path)) {
				// Delete the file
				Storage::disk('public')->delete($path);
			}

			// Optionally delete the salary record if needed
			$user->salary->delete();
		}

		// Delete the user
		$user->delete();

		return redirect()->back()->with('success', 'User deleted successfully.');
	}

	public function editPageAwak12(User $user){
		// dd($user->salaries);
		return view('edit.awak12', compact('user'));
	}
	public function editPageKantor(User $user){
		// dd($user->salaries);
		return view('edit.kantor', compact('user'));
	}
	public function updateAwak12(Request $request, $userId){
		$user = User::with('salary.deliveries')->findOrFail($userId);

		// Validate user data
		$user->update($request->only(['nama', 'kantor']));

		// Update salary
		$salary = $user->salary;
		$salary->gaji_pokok = $request->input('gaji_pokok', $salary->gaji_pokok);
		$salary->bulan = $request->input('bulan', $salary->bulan);
		$salary->tahun = $request->input('tahun', $salary->tahun);
		$salary->hari_kerja = $request->input('hari_kerja', $salary->hari_kerja);
		$salary->tunjangan_makan = $request->input('tunjangan_makan', $salary->tunjangan_makan);
		$salary->potongan_bpjs = $request->input('potongan_bpjs', $salary->potongan_bpjs);
		$salary->potongan_tabungan_hari_tua = $request->input('potongan_tabungan_hari_tua', $salary->potongan_tabungan_hari_tua);
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
			$fileName = Str::title($user->nama) . '.png';

			// Delete old signature file if different
			if ($oldSignature && Storage::disk('public')->exists('ttd/' . $oldSignature)) {
				Storage::disk('public')->delete('ttd/' . $oldSignature);
			}

			// Save new signature
			Storage::disk('public')->put('ttd/' . $fileName, base64_decode($imageData));
			
			// Update the database with the new signature file name
			$salary->ttd = $fileName;
			
		}

		// Reload deliveries relation to access them
		$salary->load('deliveries');

		// Calculate total gaji
		$salary->jumlah_gaji = $salary->gaji_pokok
			+ $salary->deliveries->sum(fn($d) => $d->jumlah_retase * $d->tarif_retase)
			+ ($salary->tunjangan_makan ?? 0)
			+ ($salary->tunjangan_hari_tua ?? 0);

		$salary->save();

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

		$page = $request->input('page', 1);

		return redirect()->route('awak12.index',['page'=>$page])->with('success', 'User updated successfully!');
	}
	public function updateKantor(Request $request, $userId){
	  $user = User::with('salary')->findOrFail($userId);

	  // Validate user data
	  $user->update($request->only(['nama', 'kantor']));

	  // Update salary
	  $salary = $user->salary;

	  $salary->gaji_pokok = $request->input('gaji_pokok', $salary->gaji_pokok);
	  $salary->bulan = $request->input('bulan', $salary->bulan);
	  $salary->tahun = $request->input('tahun', $salary->tahun);
	  $salary->hari_kerja = $request->input('hari_kerja', $salary->hari_kerja);
	  $salary->tunjangan_makan = $request->input('tunjangan_makan', $salary->tunjangan_makan);
	  $salary->potongan_bpjs = $request->input('potongan_bpjs', $salary->potongan_bpjs);
	  $salary->potongan_tabungan_hari_tua = $request->input('potongan_tabungan_hari_tua', $salary->potongan_tabungan_hari_tua);
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
		  $fileName = Str::title($user->nama) . '.png';

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
		  return redirect()->route('kantor1.index',['page'=>$page])->with('success', 'user updated successfully!');
	  }
	  else if($request->input('kantor') === 'kantor 2'){
		  return redirect()->route('kantor2.index',['page'=>$page])->with('success', 'user updated successfully!');
	  }
	}

}
