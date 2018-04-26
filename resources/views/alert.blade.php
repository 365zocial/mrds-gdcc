@if(isset($action) && $action == 0)
    <div class="alert alert-success">
        <strong>Success!</strong> Added your new data.
    </div>
@elseif(isset($action) && $action == 1)
    <div class="alert alert-danger">
        <strong>Error!</strong> Can not add new data.<br>
        <strong>Error! : </strong> {{ Session::get('exception_catcher') }}
    </div>
@elseif(isset($action) && $action == 2)
    <div class="alert alert-success">
        <strong>Success!</strong> Edited your data.
    </div>
@elseif(isset($action) && $action == 3)
    <div class="alert alert-danger">
        <strong>Error!</strong> Can not edit this data.<br>
        <strong>Error! : </strong> {{ Session::get('exception_catcher') }}
    </div>
@elseif(isset($action) && $action == 4)
    <div class="alert alert-success">
        <strong>Success!</strong> Deleted your data.
    </div>
@elseif(isset($action) && $action == 5){
    <div class="alert alert-danger">
        <strong>Error!</strong> Can not delete this data.<br>
        <strong>Error! : </strong> {{ Session::get('exception_catcher') }}
    </div>
@endif
