@extends('emails.base')
@section('title')
    Alfanet Hesap Aktivasyon Email
@endsection
@section('preheader')
    Alfanet servis otomasyonu hesap aktivasyon email
@endsection
@section('content')
    <p>Merhaba,</p>
    <p>Talebinize istinaden Alfanet Servis Otomasyon sistemimizde {{$user->email}} adresine kayıtlı hesap oluşturulmuştur. Hesabınızı aktif etmek
        için aşağıdaki Hesap Aktivasyon butonuna tıklayınız.</p>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
        <tr>
            <td align="left">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td><a href="{{$link}}" target="_blank">Hesap Aktivasyon</a></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <p>Eğer buton çalışmıyorsa bu linki kopyalayıp browsera yapıştırınız: {{$link}}</p>
    {{--<p>This is a really simple email template. Its sole purpose is to get the recipient to click the button with no
        distractions.</p>
    <p>{{$link}}</p>--}}
    <p>İyi Çalışmalar...</p>
@endsection
