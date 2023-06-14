@extends('layouts.app')
@section('title', 'Customer')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Customer Page</h1>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow rounded">
                <div class="card-header">Customer Data</div>
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCustomer">
                        Create
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="createCustomer" tabindex="-1" aria-labelledby="createCustomerLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="createCustomerLabel">Create New Customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('customer.create') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="code" class="form-label">Code</label>
                                        <input type="text" name="code" class="form-control" placeholder="code...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="john doe...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" name="city" class="form-control" placeholder="jakarta...">
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-borderless">
                            <thead class="text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $no => $customer)
                                    <tr class="text-center">
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $customer->code }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->city }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editCustomer">
                                                Edit
                                            </button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade text-left" id="editCustomer" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="editCustomerLabel">Edit Customer {{ $customer->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="code" class="form-label">Code</label>
                                                                <input type="text" name="code" class="form-control" placeholder="code..." value="{{ $customer->code }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Name</label>
                                                                <input type="text" name="name" class="form-control" placeholder="john doe..." value="{{ $customer->name }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="city" class="form-label">City</label>
                                                                <input type="text" name="city" class="form-control" placeholder="jakarta..." value="{{ $customer->city }}">
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <form class="d-inline-block" action="{{ route('customer.delete', $customer->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger rounded">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection