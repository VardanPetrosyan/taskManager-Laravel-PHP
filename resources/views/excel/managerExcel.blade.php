<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        th{
            width: 200px;
            background: red;
        }

    </style>
</head>
<body>
@php
    $i = 1
@endphp
@foreach($orders as $ordId => $orderarr)
    <table>
        <thead>
        @if($i == 1)
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="5">
                    ՀՀ ԿԳՆ «ԵՐԵՎԱՆԻ «ՄԽԻԹԱՐ ՍԵԲԱՍՏԱՑԻ» ԿՐԹԱՀԱՄԱԼԻՐ» ՊՈԱԿ
                </th>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Թույլատրեց՝</td>
                <td></td>
                <td></td>
                <td></td>
                <td>Լիլիթ Ազիզխանյան</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
{{--                    <img src="{{asset('/public/img/storagr.png')}}" alt="storagr">--}}
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Բաց թողեց՝</td>
                <td></td>
                <td>________________</td>
                <td></td>
                <td>Վլադիկ Աբրահամյան</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>ստորագրություն</td>
            </tr>
            <tr></tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="3">
                    Պ Ա Հ Ա Ն Ջ Ա Գ Ի Ր
                </th>
            </tr>
            <tr></tr>
            <tr></tr>
        @endif
        <tr></tr>
        <tr></tr>
        <tr>
            <th>Հ/Հ</th>
            {{--<th>ID</th>--}}
            <th>Կոդ</th>
            <th>Անվանում</th>
            <th>Կատեգորիա</th>
            <th>Քանակ</th>
            <th>Միավոր</th>
            <th>Պատվիրման Ամսաթիվ</th>
            <th>Օգտագործման վայրը / Օգտագործող անձը</th>
            <th>Գին</th>
            <th>Գումար</th>
            <th>Պատվիրատու</th>

        </tr>
        </thead>
        <tbody >
        @php
            $a = 1
        @endphp
        @foreach($orderarr as $order)
            @if($a==1)
                <tr>
                    <td colspan="2">Շենք՝  </td>
                    <td colspan="9">{{$order->schoolName}}  </td>
                </tr>
            @endif
            <tr>
                <td style="border-color: #000; border-width: 2px; border-style: solid;">{{$i}}</td>
                {{--<td>{{$ordId}}</td>--}}
                <td>{{$order->code}}</td>
                <td>{{$order->productName}}</td>
                <td>{{$order->categoryName}}</td>
                <td>{{$order->count}}</td>
                <td>{{$order->unit}}</td>
                <td>{{$order->created_at}}</td>
                <td>{{$order->exploiter}}</td>
                <td>{{$order->price}}</td>
                <td>{{$order->count*$order->price}}</td>
                <td>{{"$order->userId (Id) / $order->userName "}}</td>
            </tr>
            @php
                $a++
            @endphp
            @php
                $i++
            @endphp
        @endforeach
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3">Ընդունեց ___________________________</td>


            <td colspan="3">{{$order->userName}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td> ստորագրություն</td>
        </tr>
        <tr></tr>
        <tr></tr>
        </tbody>
    </table>



@endforeach






</body>
</html>
