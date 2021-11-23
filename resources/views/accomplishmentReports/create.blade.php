@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-12">
        	{{-- Success Message --}}
	        	@if (session()->has('success'))
		        	<div class="flex-row text-center" id="success_alert">
		        	    <div class="alert alert-success alert-dismissible fade show" role="alert">
		        	        {{ session('success') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
		        	    </div>
		        	</div>
	        	@endif
        	{{-- Error Message --}}
	        	@if (session()->has('error'))
		        	<div class="flex-row text-center" id="error_alert">
		        	    <div class="alert alert-danger alert-dismissible fade show" role="alert">
		        	        {{session('error')}}
		        	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		        	            <span aria-hidden="true">&times;</span>
		        	        </button>
		        	    </div>
		        	</div>
	        	@endif
	        {{-- Multi-Error Message --}}
	        	@if(session('errors'))
		        	<div class="flex-row text-center" id="errors_alert">
		        	    <div class="alert alert-danger alert-dismissible fade show" role="alert">
			        		@foreach ($errors->all() as $error)
			        	    	{{ $error }}
			        	    	@if(!($loop->last))
			        	    		<br>
			        	    	@endif
							@endforeach
		        	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		        	            <span aria-hidden="true">&times;</span>
		        	        </button>
		        	    </div>
		        	</div>
        		@endif

        	{{-- Title and Breadcrumbs --}}
        	<div class="d-flex justify-content-between align-items-center">
        	    {{-- Title --}}
        	    <h2 class="display-7 text-left text-break">Organization Report</h2>

        	    {{-- Breadcrumbs --}}
        	    <nav aria-label="breadcrumb align-items-center">
        	        <ol class="breadcrumb justify-content-center">
        	            <li class="breadcrumb-item">
        	                <a href="{{route('home')}}" class="text-decoration-none">Home</a>
        	            </li>
        	            <li class="breadcrumb-item">
        	                <a href="{{route('accomplishmentreports.index')}}" class="text-decoration-none">
        	                    Accomplishment Reports
        	                </a>
        	            </li>
        	            <li class="breadcrumb-item active" aria-current="page">
        	                Create Accomplishment Report
        	            </li>
        	        </ol>
        	    </nav>
        	</div>

        	<hr>

        	<h2 class="display-7 text-center">Choose from Semestral, Quarterly, or Custom</h2>

        	{{-- Semestral Card --}}
        	<div class="row mb-1 mt-1">
                <div class="card w-100">
                	<h4 class="card-header card-text text-center bg-maroon text-white fw-bold">Semestral</h4>
                	<form action="{{route('accomplishmentreports.showChecklist')}}" enctype="multipart/form-data" method="POST" id="semestralReportForm">
		            	<div class="card-body">
		            		{{-- School Year Select --}}
		            		<div class="row text-center">
		            			<div class="col">
		            				<h3 class="text-center">School Year</h3>
		            			</div>
		            			<div class="col">
			            			@if( $schoolYears->count() > 0)
			            				<select class="form-select" name="school_year">
			        					@php $i = 1; @endphp
			        					@foreach($schoolYears as $year)
			            					<option @if ($loop->first) selected @endif
			            						value="{{ $year->id }}">
			            					{{ $year->year_start . ' - ' . $year->year_end}}
			            					</option>	
			        					@endforeach
			            				</select>
			        				@else
			        					<p class="bg-danger">NO OPTION AVAILABLE</p>
			        				@endif
		            			</div>
		            		</div>

		            		{{-- Semester Buttons --}}
		            		<div class="row mt-3">
		            			<div class="col"><h6 class="text-center fw-bold fs-3">Select Semester</h6></div>
		            		</div>
		    				<div class="row text-center mt-3">
								<div class="col">
	        						<button class="btn btn-primary text-center text-white h-100" name="first_semester" value="first_semester" type="submit" >1st Semester</button>
		        				</div>
		    					<div class="col">
	    							<button class="btn btn-primary text-center text-white h-100" name="second_semester" value="second_semester" type="submit" >2nd Semester</button>
		    					</div>
		    				</div>
		            	</div>
			            @csrf
			            <input type="hidden" name="semestral" value="semestral">
            		</form>
                </div>
            </div>
            {{-- Semestral Errors --}}
	    		@error('first_semester')
		    		<div class="row">
				        <span class="d-block invalid-feedback" role="alert">
				            <strong>{{ $message }}</strong>
				        </span>
				    </div>
			    @enderror
	    		@error('second_semester')
		    		<div class="row">
				        <span class="d-block invalid-feedback" role="alert">
				            <strong>{{ $message }}</strong>
				        </span>
		            </div>
			    @enderror

            <hr>

            {{-- Quarterly Card --}}
            <div class="row mb-1 mt-1">
	    		<div class="card w-100">
					<h4 class="card-header card-text text-center bg-maroon text-white fw-bold">Quarterly</h4>
					<form action="{{route('accomplishmentreports.showChecklist')}}" enctype="multipart/form-data" method="POST" id="quarterlyReportForm">
		    			<div class="card-body">
		    				<h5 class="card-title text-center fw-bold fs-3">{{ date('Y') }}</h5>
		    				{{-- Quarter Buttons --}}
		    				<div class="row text-center">
								<div class="col">
		    						<button class="btn btn-primary text-white h-100" name="first_quarter" value="first_quarter" type="submit">1st Quarter</button>
		        				</div>
		    					<div class="col">
									<button class="btn btn-primary text-white h-100" name="second_quarter" value="second_quarter" type="submit">2nd Quarter</button>
		    					</div>
		    					<div class="col">
		    						<button class="btn btn-primary text-white h-100" name="third_quarter" value="third_quarter" type="submit">3rd Quarter</button>

		    					</div>
		    					<div class="col">
		    						<button class="btn btn-primary text-white h-100"  name="fourth_quarter" value="fourth_quarter" type="submit">4th Quarter</button>
		    					</div>        					
		    				</div>
		    				{{-- Quarter Labels --}}
		    				<div class="row text-center text-muted">
		    					<div class="col">
		    						<label for="first_quarter" class="col-form-label">January - March</label>
		    					</div>
		    					<div class="col">
		    						<label for="second_quarter" class="col-form-label">April - June</label>
		    					</div>
		    					<div class="col">
		    						<label for="third_quarter" class="col-form-label">July - September</label>
		    					</div>
		    					<div class="col">
		    						<label for="fourth_quarter" class="col-form-label">October - December</label>
		    					</div>	
		    				</div>
		    			</div>
		    			@csrf
		        		<input type="hidden" name="quarterly" value="quarterly">
	    			</form>
	    		</div>
        	</div>
            {{-- Quarterly Errors --}}
	    		@error('first_quarter')
	    		<div class="row">
			        <span class="d-block invalid-feedback" role="alert">
			            <strong>{{ $message }}</strong>
			        </span>
			    </div>
			    @enderror
	    		@error('second_quarter')
	    		<div class="row">
			        <span class="d-block invalid-feedback" role="alert">
			            <strong>{{ $message }}</strong>
			        </span>
	            </div>
			    @enderror
				@error('third_quarter')
				<div class="row">
			        <span class="d-block invalid-feedback" role="alert">
			            <strong>{{ $message }}</strong>
			        </span>
			    </div>
			    @enderror
				@error('fourth_quarter')
				<div class="row">
			        <span class="d-block invalid-feedback" role="alert">
			            <strong>{{ $message }}</strong>
			        </span>
		        </div>
			    @enderror

        	<hr>

        	{{-- Custom Card --}}
        	<div class="row mt-1">
        		<div class="card w-100">
        			<h4 class="card-header card-text text-center bg-maroon text-white fw-bold">Custom</h4>
    				<form action="{{route('accomplishmentreports.showChecklist')}}" enctype="multipart/form-data" method="POST" id="customReportForm" class="w-100">
        			<div class="card-body">
        				{{-- Start Date Input --}}
        				<div class="form-group row">
        				    <label for="custom_start_date" class="col-md-4 col-form-label">Start Date</label>
        				    <input id="custom_start_date" 
	        				    type="date" 
	        				    class="form-control @error('custom_start_date') is-invalid @enderror" 
	        				    name="custom_start_date" 
	        				    value="{{ old('custom_start_date') }}">
        				    @error('custom_start_date')
        				        <span class="invalid-feedback" role="alert">
        				            <strong>{{ $message }}</strong>
        				        </span>
        				    @enderror
        				</div>

        				{{-- End Date Input --}}
        				<div class="form-group row">
        				    <label for="custom_end_date" class="col-md-4 col-form-label">End Date</label>
        				    <input id="custom_end_date"
	        				    type="date" 
	        				    class="form-control @error('custom_end_date') is-invalid @enderror" 
	        				    name="custom_end_date" 
	        				    value="{{ old('custom_end_date') }}">
        				    @error('custom_end_date')
        				        <span class="invalid-feedback" role="alert">
        				            <strong>{{ $message }}</strong>
        				        </span>
        				    @enderror
        				</div>
        				<div class="row text-center justify-content-center">
							<div class="flex-row my-2 text-center">
	        				    <button class="btn btn-primary text-white" type="submit">
	        				    	<i class="fas fa-clipboard-list"></i> Submit Custom
	        				    </button>
	        				    @csrf
	        				    <input type="hidden" name="custom" value="custom">
	        				</div>
        				</div>
        			</form>
        		</div>
        	</div>

            <div class="flex-row my-2 text-center">
                <a href="{{route('home')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-home"></i> Go Home
                </a>
            </div>
    	</div>
	</div>
</div>
@endsection
