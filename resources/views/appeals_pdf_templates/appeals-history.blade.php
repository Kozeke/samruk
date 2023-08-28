<div style="margin-bottom: 2%; text-align: left">
    <h2 class="title-page">История обращении арендатора</h2>
</div>
<div class="formatted">

    <table class="w-100">
        <thead>
        <tr class="text-center">
            <th>ID</th>
            <th>Название</th>
            <th>Ссылка</th>
            <th>Ответ</th>
            <th>Статус</th>
            <th>Дата создания</th>
        </tr>
        </thead>
        <tbody>
        @foreach($appealsHistory as $value)
            <tr>
                <td>{{$value->id}}</td>
                <td>{{$value->title}}</td>
                <td><a target="_blank" href="{{asset($value->link)}}">link</a> </td>
                <td>{{$value->reply}}</td>
                <td>{{$value->status}}</td>
                <td>{{$value->created_at}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

