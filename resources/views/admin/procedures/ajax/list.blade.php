<table class="table table-striped mb-0">
    <thead style="background-color: #A41C20;">
        <tr>
            <th style="width: 25%;" scope="col">Procedure Name</th>
            <th style="width: 50%;">Description</th>
            <th style="width: 7.5%;" scope="col">Access Level</th>
            <th style="width: 7.5%" scope="col">No. of Waypoints</th>
            <th style="width: 10%;" scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($procedures as $procedure)
        <tr>
            <td>{{$procedure->procedure_name}}</td>
            <td>{{$procedure->procedure_description}}</td>
            <td>$procedure->access_level()</td>
            <td>$procedure->waypointCount()</td>
            <td><button type="button" class="btn btn-sm btn-danger">Delete</button></td>
        </tr>
        @endforeach
    </tbody>
</table>