@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
        <div class="col-md-10">
        	{{-- Error/Success Messages --}}
        	@if (session('success'))
        	<div id="success_alert">
        	    <div class="alert alert-success alert-dismissible fade show" role="alert">
        	        {{ session('success') }}
        	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	            <span aria-hidden="true">&times;</span>
        	        </button>
        	    </div>
        	</div>
        	@elseif(session('error'))
        	<div id="error_alert">
        	    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        	        {{session('error')}}
        	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	            <span aria-hidden="true">&times;</span>
        	        </button>
        	    </div>
        	</div>
        	@elseif(session('errors'))
        	<div id="error_alert">
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
        	<div class="row">
        	    {{-- Title --}}
        	    <h4 class="display-5 text-center">Organization Report</h4>
        	    <p class="text-center">Choose from Semestral, Quarterly, & Custom</p>
        	    {{-- Breadcrumbs --}}
        	    <nav aria-label="breadcrumb">
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

        	<div class="row mb-1 mt-1">
                <div class="card w-100">
                	<h4 class="card-header card-text text-center bg-maroon text-white fw-bold">Semestral</h4>
                	<form action="{{route('accomplishmentreports.showChecklist')}}" enctype="multipart/form-data" method="POST" id="semestralReportForm">
		            	<div class="card-body">
		            		<div class="row text-center">
		            			<div class="col"><h3 class="text-center">School Year</h3></div>
		            			<div class="col">
		            			@if( $schoolYears->count() > 0)
		            				<select class="form-select" name="school_year">
		        					@php $i = 1; @endphp
		        					@foreach($schoolYears as $year)
		            					<option @if ($loop->first)  selected @endif
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
		            		@if($schoolYears->count() > 0)
		            		<div class="row mt-3">
		            			<div class="col"><h6 class="text-center">Select Semester</h6></div>
		            		</div>
		    				<div class="row text-center mt-3">
								<div class="col">
	        						<button class="btn btn-primary text-center text-white" name="first_semester" value="first_semester" type="submit" style="height:100%;">1st Semester</button>
		        				</div>
		    					<div class="col">
	    							<button class="btn btn-primary text-center text-white" name="second_semester" value="second_semester" type="submit" style="height:100%;">2nd Semester</button>
		    					</div>
		    				</div>
	    					@endif
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
            <div class="row mb-1 mt-1">
	    		<div class="card w-100">
					<h4 class="card-header card-text text-center bg-maroon text-white fw-bold">Quarterly</h4>
					<form action="{{route('accomplishmentreports.showChecklist')}}" enctype="multipart/form-data" method="POST" id="quarterlyReportForm">
		    			<div class="card-body">
		    				<h5 class="card-text text-center">{{ date('Y') }}</h5>
		    				<div class="row text-center">
								<div class="col">
		    						<button class="btn btn-primary text-white" name="first_quarter" value="first_quarter" type="submit" style="height:100%;">1st Quarter</button>
		        				</div>
		    					<div class="col">
									<button class="btn btn-primary text-white" name="second_quarter" value="second_quarter" type="submit" style="height:100%;">2nd Quarter</button>
		    					</div>
		    					<div class="col">
		    						<button class="btn btn-primary text-white" name="third_quarter" value="third_quarter" type="submit" style="height:100%;">3rd Quarter</button>

		    					</div>
		    					<div class="col">
		    						<button class="btn btn-primary text-white"  name="fourth_quarter" value="fourth_quarter" type="submit" style="height:100%;">4th Quarter</button>
		    					</div>        					
		    				</div>
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
        	<div class="row mt-1">
        		<div class="card w-100">
        			<h4 class="card-header card-text text-center bg-maroon text-white fw-bold">Custom</h4>
    				<form action="{{route('accomplishmentreports.showChecklist')}}" enctype="multipart/form-data" method="POST" id="customReportForm" class="w-100">
        			<div class="card-body">
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
        				    <button class="btn btn-primary text-white" type="submit">Submit Custom</button>
        				</div>
        			</div>
        			@csrf
        			<input type="hidden" name="custom" value="custom">
        			</form>
        		</div>
        	</div>

            <div class="flex-row my-2 text-center">
                <a href="{{route('home')}}"
                    class="btn btn-secondary text-white"
                    role="button">
                        Go Home
                </a>
            </div>
            
    	</div>
	</div>

</div>
@endsection