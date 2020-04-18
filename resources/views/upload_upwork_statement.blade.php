@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload Upwork Statement</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" enctype="multipart/form-data" action="{{ route('upwork.statement') }}">
                            @csrf

                            <div class="form-group">
                                <label for="organization-id">Organization</label>
                                <select class="form-control" id="organization-id"
                                        name="organization_id"
                                        aria-describedby="organization-id-help">
                                    <option>Select Organization</option>
                                    @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                    @endforeach
                                </select>
                                <small id="organization-id-help" class="form-text text-muted">Select the Organization you'd like to upload the transactions to.
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="upwork-statement">Upwork Statment CSV</label>
                                <input type="file" class="form-control" id="upwork-statement"
                                       name="upwork_statement"
                                       aria-describedby="upwork-statement-csv-help"
                                       placeholder="Select Upwork Statement CSV">
                                <small id="upwork-statement-csv-help" class="form-text text-muted">Upload your Upwork
                                    Transaction Statement CSV.
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
