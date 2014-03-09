<?php

class CompanyController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$companies = Company::all();
		return Response::json($companies->toArray());
	}

	/**
	 * voting for the characteristic
	 */
	public function vote() {
		$ccid = (int) $_POST['ccid'];
		$userId = 1;
		$voteCnt = UserVote::where('userId', '=', $userId)->where('companyCharacteristicId', '=', $ccid)->get()->count();
		if ($voteCnt > 0) {
			return Response::json(array('error' => 'duplicate', 'count' => $voteCnt));
		}
		UserVote::create(array('userId' => $userId, 'companyCharacteristicId' => $ccid));
		$cc = CompanyCharacteristic::where('id', '=', $ccid)->first();
		$cc->increment('count');
		return Response::json(array('count' => $cc->count+1));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if (!is_numeric($id)) return 'The company id must be numeric';
		$company = DB::table('Company')->where('id', '=', $id)->select('name')->first();
		$out = (array) $company;
		$characteristics = DB::table('CompanyCharacteristic')
										->leftJoin('Characteristic', 'CompanyCharacteristic.characteristicId', '=', 'Characteristic.id')
										->where('CompanyCharacteristic.companyId', '=', $id)
										->select('Characteristic.name', 'CompanyCharacteristic.count', 'CompanyCharacteristic.id as ccid')
										->get();
		$out['characteristic'] = $characteristics;
		return Response::json($out);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}