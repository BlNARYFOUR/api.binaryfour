<h2>Hello Brend :)</h2>

<p>
    A registration has been requested with email: {{$email}}
    <br />
    The verification code is: {{ $verificationCode }}
    Click <a href="{{env('FRONTEND_URL')}}?verify=1&token={{$verificationCode}}">here</a> to verify the user.
</p>