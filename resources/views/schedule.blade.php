<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Schedule</title>
</head>
<body>

    <h3>Employee Id: </h3> 
    <p>{{ $employee->api_id }}</p>
    
    <h3>Employee: </h3> 
    <p>{{ $employee->forename }} {{ $employee->surname }}</p>

    @foreach($data as $item)
        <p>Day: {{$item['day']}}<p>
        <p>Subject: {{$item['subject']}}
        <p>Room: {{$item['lesson']['room']}}
        <p>Time: {{$item['time']}}

        <p>Students: </p>
        <div class="students">
            @foreach($item['students'] as $student) 
                <p style="margin-right: 10px;">{{$student->forename}} {{$student->surname}}, </p>
            @endforeach
        </div>
    @endforeach
    
</body>
</html>

<style>
    body{
        background-color: lightgray;
    }
    .students {
        margin-bottom: 10px;
        display: inline-flex;
        text-align: center;
    }
</style>