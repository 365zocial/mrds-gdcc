<form action="{{ url('staff/searchname') }}" class="form" method="post">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <select name="typename" id="" class="form-control">
                <option value="" selected disabled>ค้นหาจาก</option>
                <option value="localname">Local Name</option>
                <option value="vernacularname">Vernacular Name</option>
                <option value="commonname">Common Name</option>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" name="search">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-block btn-success">ค้นหา</button>
        </div>
    </div>
</form>
<br>