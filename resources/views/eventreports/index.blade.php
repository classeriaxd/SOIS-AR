@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-8">
        	<h2 class="text-center display-3">Event Reports</h2>
        	<div class="row">
                <form action="/e/reports" enctype="multipart/form-data" method="POST" id="reportForm">
                @csrf
        		<div class="card">
        			<div class="card-header text-center align-middle">
        			    <div class="display-5">Options</div>
        			</div>
        			<div class="card-body">
        				<h5 class="card-title">Generate Event Report for:</h5>
						
        				<div class="row text-center">
							<div class="col ">
	        					<a href="#">
	        						<button class="btn btn-primary" id="first" name="first" value="first" style="height:100%;">
	        							1st Quarter of {{date('Y')}}
	        						</button>
	        					</a>
	        				</div>
	    					<div class="col">

	    						<a href="#">
	    							<button class="btn btn-primary" id="second" name="second" value="second" style="height:100%;">
	    								2nd Quarter of {{date('Y')}}
	    							</button>
	    						</a>
	    					</div>
	    					<div class="col">
	    						<a href="#">
	    							<button class="btn btn-primary" id="third" name="third" value="third" style="height:100%;">
	    								3rd Quarter of {{date('Y')}}
	    							</button>
	    						</a>
	    					</div>
	    					<div class="col">
	    						<a href="#">
	    							<button class="btn btn-primary" id="fourth" name="fourth" value="fourth" style="height:100%;">
	    								4th Quarter of {{date('Y')}}
	    							</button>
	    						</a>
	    					</div>        					
        				</div>
        				<div class="row text-center text-muted">
        					<div class="col">
        						<label for="first" class="col-form-label">January - March</label>
        					</div>
        					<div class="col">
        						<label for="second" class="col-form-label">April - June</label>
        					</div>
        					<div class="col">
        						<label for="third" class="col-form-label">July - September</label>
        					</div>
        					<div class="col">
        						<label for="fourth" class="col-form-label">October - December</label>
        					</div>	
        				</div>
    					<hr>
    					<h6 class="card-title">Custom</h6>
    					<div class="form-group row">
    					    <label for="start_date" class="col-md-4 col-form-label">Start Date</label>
    					    <input id="start_date" 
    					    type="date" 
    					    class="form-control @error('start_date') is-invalid @enderror" 
    					    name="start_date" 
    					    value="{{ old('start_date') }}" autocomplete="start_date">
    					    @error('start_date')
    					        <span class="invalid-feedback" role="alert">
    					            <strong>{{ $message }}</strong>
    					        </span>
    					    @enderror
    					</div>
    					<div class="form-group row">
    					    <label for="end_date" class="col-md-4 col-form-label">End Date</label>
    					    <input id="end_date"
    					    type="date" 
    					    class="form-control @error('end_date') is-invalid @enderror" 
    					    name="end_date" 
    					    value="{{ old('end_date') }}" autocomplete="end_date">
    					    @error('end_date')
    					        <span class="invalid-feedback" role="alert">
    					            <strong>{{ $message }}</strong>
    					        </span>
    					    @enderror
    					</div>
                        <div class="row text-center justify-content-center">
                            <button class="btn btn-primary" name="custom" value="custom">Submit</button>
                        </div>
        			</div>
        		</div>
                </form>
        	</div>
            
            <div class="row justify-content-center mt-2">
                <a href="/e">
                    <button class="btn btn-secondary">Go back</button>
                </a>
            </div>
    	</div>
	</div>

</div>
@endsection