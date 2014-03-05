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
		UserVote::create(array('userId' => 1, 'companyCharacteristicId' => $ccid));
		$cc = CompanyCharacteristic::where('id', '=', $ccid)->first();
		$cc->increment('count');
		return $cc->count+1;
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
		$company = Company::find($id);
		$characteristics = $company->characteristic;
		foreach ($characteristics as $ch) {
			$ch->companyCharacteristic;
		}
		$out = $company->toArray();
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