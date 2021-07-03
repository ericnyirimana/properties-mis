<form action="{{route('properties.filter')}}" method="POST">
    @csrf
    <label for="Search">Search</label>
    <input type="text" class="form-control" name="key_search" id="key_search" placeholder="Search..">
    <button type="submit">Submit</button>               
</form>