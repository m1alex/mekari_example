@extends('layouts.app')
    
@section('content')
    <script src="{{ url('/assets/js/items.js') }}"></script>
    
    <span id="domain" style="display:none;">{{ url('/') }}</span>
    <span id="csrf" style="display:none;">{{ csrf_token() }}</span>

    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Add new item
                </div>
                
                <script type="text/javascript">

                </script>
                
                <div class="panel-body">
                    <form id="add-item-form" action="{{ url('/items/add') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label for="task" class="col-sm-3 control-label">Title for item</label>
                            <div class="col-sm-6">
                                <input type="text" name="title" id="item-title" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button id="add-item-button" type="submit" class="btn btn-default">
                                    <i class="fa fa-plus"></i> Add Item
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Items
                    </div>

                    <div class="panel-body">
                        <table id="items-list" class="table table-striped">
                            <thead>
                                <th width="20%">Selections</th>
                                <th width="10%">ID</th>
                                <th width="50%">Item title</th>
                                <th width="20%">Actions</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        <form id="remove-selected-items-form" action="{{ url('/items/remove-selected') }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" id="remove-seleted-items" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i> Remove selected 
                                            </button>
                                        </form>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <form id="remove-all-items-form" action="{{ url('/items/remove-all') }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" id="remove-all-items" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i> Remove all 
                                            </button>
                                        </form>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
