@extends('emails.base')
@section('title')
    Alfanet - Şifre Sıfırlama Email
@endsection
@section('preheader')@endsection
@section('content')
    <p>Merhaba, {{$user->name}}</p>
    <p>Şifrenizi alttaki butona tıklayarak sıfırlayabilirsiniz.</p>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
        <tr>
            <td align="left">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td><a href="{{$link}}" target="_blank">Şifre Sıfırlama</a></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <p>Eğer buton çalışmıyorsa bu linki kopyalayıp browser a yapıştırınız: {{$link}}</p>
@endsection
