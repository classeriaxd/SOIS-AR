@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
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
                <h5 class="display-5 text-center">Event Natures</h5>
                {{-- Breadcrumbs --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.home')}}" class="text-decoration-none">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Maintenances
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Event Natures
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="flex-row my-2 text-center">
                <a href="{{ route('admin.maintenance.eventNatures.create') }}"
                    class="btn btn-secondary text-white"
                    role="button">
                        <i class="fas fa-plus"></i> Add Event Nature
                </a>
            </div>
            
            <div class="card w-100">
                <table class="w-100 table table-bordered table-striped table-hover border border-dark">
                    <thead class="align-middle bg-maroon text-white fw-bold fs-6">
                        <th>#</th>
                        <th>Nature</th>
                        <th>Helper</th>
                        <th>Option</th>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach($eventNatures as $nature)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $nature->nature }}</td>
                            <td style="width: 50%;">{{ $nature->helper }}</td>
                            <td class="text-center">
                                <a class="btn btn-success text-white" 
                                    href="{{ route('admin.maintenance.eventNatures.show', ['nature_id' => $nature->event_nature_id]) }}" 
                                    role="button">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-primary text-white" 
                                    href="{{ route('admin.maintenance.eventNatures.edit', ['nature_id' => $nature->event_nature_id]) }}" 
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
            
            <div class="flex-row my-2 text-center">
                <a href="{{ route('admin.home') }}"
                    class="btn btn-secondary text-white"
                    role="button">
                        Go Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

