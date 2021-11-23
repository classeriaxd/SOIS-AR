@extends('layouts.admin-app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- Success Alert --}}
                @if (session()->has('success'))
                    <div class="flex-row text-center" id="success_alert">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            {{-- Error Alert --}}
                @if (session()->has('error'))
                    <div class="flex-row text-center" id="success_alert">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            {{-- Title and Breadcrumbs --}}
            <div class="row">
                {{-- Title --}}
                <h4 class="display-5 text-center">{{ $tabularTable->tabular_table_name }}</h4>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Maintenances
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.maintenance.tabularTables.index')}}" class="text-decoration-none">
                                Tabular AR Tables
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                           {{ $tabularTable->tabular_table_name }}
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="flex-row d-flex justify-content-center my-1">
                <div class="card w-50 text-center">
                    <h5 class="card-header card-title text-center bg-maroon text-white fw-bold">Table Name: {{ $tabularTable->tabular_table_name }}</h5>
                    <div class="card-body">
                        <p class="card-text">{{ $tabularTable->description ?? 'No Description Provided'}}</p>
                        <p class="card-text">Reference Table No. : {{ $tabularTable->reference_table_number ?? 'No Reference Number Provided' }}</p>
                        <hr class="my-2">
                        <p class="card-text my-1">Options</p>
                        <div class="flex-row">
                            <a href="{{ route('admin.maintenance.tabularTables.edit', ['tabular_table_id' => $tabularTable->tabular_table_id]) }}"
                                class="btn btn-primary text-white mx-1"
                                role="button">
                                    Edit Tabular AR Table
                            </a>
                            <a href="#"
                                class="btn btn-danger text-white mx-1"
                                role="button"
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteTabularTableReminderModal">
                                    Delete Tabular AR Table
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-1"></hr>

            <h4 class="display-6 text-center my-1">Columns</h4>

            <div class="flex-row my-1 text-center ">
                <a href="{{ route('admin.maintenance.tabularTables.tabularColumns.create', ['tabular_table_id' => $tabularTable->tabular_table_id]) }}"
                    class="btn btn-primary text-white"
                    role="button">
                        Add a Column
                </a>
            </div>

            <div class="card w-100 my-2">
                <table class="w-100 table table-bordered table-striped table-hover border border-dark">
                    <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                        <th>#</th>
                        <th>Column Name</th>
                        <th>Description</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach($tabularColumns as $tabularColumn)
                        <tr>
                            <td>{{ $i }}</td>
                            <td style="width: 30%;">{{ $tabularColumn->tabular_column_name }}</td>
                            <td style="width: 30%;">{{ $tabularColumn->description ?? 'No Description Provided' }}</td>
                            <td class="text-center">
                                <a class="btn btn-success text-white" 
                                    href="{{ route('admin.maintenance.tabularTables.tabularColumns.show', ['tabular_table_id' => $tabularTable->tabular_table_id, 'tabular_column_id' => $tabularColumn->tabular_column_id]) }}" 
                                    role="button">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-primary text-white" 
                                    href="{{ route('admin.maintenance.tabularTables.tabularColumns.edit', ['tabular_table_id' => $tabularTable->tabular_table_id, 'tabular_column_id' => $tabularColumn->tabular_column_id]) }}" 
                                    role="button">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>    

                        </tr>
                    @php $i += 1; @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    <hr>

    <div class="flex-row my-2 text-center">
        <a href="{{ route('admin.maintenance.tabularTables.index') }}"
            class="btn btn-secondary text-white"
            role="button">
                <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>

    {{-- Tabular Table Delete Reminder Modal --}}
        <div class="modal fade" id="deleteTabularTableReminderModal" tabindex="-1" aria-labelledby="deleteTabularTableReminderLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-maroon text-white fw-bold">
                        <h5 class="modal-title" id="deleteTabularTableReminderLabel">Tabular AR Table Deletion</h5>
                        <button type="button" class="btn-close text-white bg-maroon" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="text-center">Reminder for Tabular AR Table Deletion</h5>
                        <ul>
                            <li>Deleted Tabular Tables will not be permanently deleted and can be restored.</li>
                            <li>A Notification will be sent to all concerned members of the Organization (Documentation Officers and President).</li>
                            <li>This Tabular AR Table will not be made available as a choice for creating future Accomplishment Reports.</li>
                            <li><strong>An IT Personnel must be informed to adjust this changes in code.</strong></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                        <button type="button" 
                            class="btn btn-danger text-white" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteTabularTableModal"
                            data-bs-dismiss="modal">
                            <i class="fas fa-check"></i> Proceed
                        </button>
                    </div>
                </div>
            </div>
        </div>

    {{-- Tabular Table Delete Modal --}}
        <div class="modal fade" id="deleteTabularTableModal" tabindex="-1" aria-labelledby="deleteTabularTableLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{route('admin.maintenance.tabularTables.destroy', ['tabular_table_id' => $tabularTable->tabular_table_id])}}" method="POST" id="tabularTableDeleteForm">
                        @method('DELETE')
                        @csrf

                        <div class="modal-header bg-maroon text-white fw-bold">
                            <h5 class="modal-title" id="deleteTabularTableLabel">Tabular AR Table Deletion</h5>
                            <button type="button" class="btn-close text-white bg-maroon" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5 class="text-center fw-bold">Verification</h5>
                            <div class="form-group row my-1">
                                <label for="verification" class="form-label text-center">Please type <b>{{ $tabularTable->tabular_table_name }}</b> to confirm</label>
                                <input id="verification" 
                                type="text" 
                                class="form-control text-center @error('verification') is-invalid @enderror border border-danger text-danger fw-bold" 
                                name="verification" 
                                autofocus
                                required>
                                @error('verification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <hr>
                            <h5 class="text-center fw-bold">Notification Form</h5>
                            <div class="form-group row my-2">
                                <label for="notificationTitle" class="form-label">Notification Title</label>
                                <input id="notificationTitle" 
                                type="text" 
                                class="form-control @error('notificationTitle') is-invalid @enderror" 
                                name="notificationTitle" 
                                value="{{ 'SYSTEM: Deletion of Tabular AR Table: ' .  $tabularTable->tabular_table_name}}" 
                                required>
                                @error('notificationTitle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group row my-2">
                                <label for="notificationDescription" class="form-label">Description</label>    
                                <textarea id="notificationDescription" 
                                class="form-control @error('notificationDescription') is-invalid @enderror" 
                                name="notificationDescription"
                                rows="6"
                                required>{{ 'The Tabular AR Table:  ' . $tabularTable->tabular_table_name . ', will not be available on future creation of Accomplishment Reports. (State your reasons/intentions here and other plans for this tabular table.)' }}</textarea>
                                @error('notificationDescription')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row text-center">
                                <small>If the fields are empty, please refresh the page.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                            <button type="submit" class="btn btn-danger text-white"><i class="fas fa-check"></i> Proceed</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) { 
            @if (count($errors) > 0)
                var deleteTabularTableModal = new bootstrap.Modal(document.getElementById('deleteTabularTableModal'));
                deleteTabularTableModal.show();
            @endif
        });
    </script>
@endsection

