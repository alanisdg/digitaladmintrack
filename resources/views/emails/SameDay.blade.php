<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body style="    background-color: #f3f0f0;">
		<table>
		<tr>
			<td></td>
		</tr>
	</table>
	<div style="padding: 40px 50px;
    background-color: #005ddc;
    border-radius: 5px;
    border: 1px solid #09469a;
    width: 60%;
    margin: 40px auto;"  >
		<img src="http://digitaladmintrack.com/images/logodat.png" alt="logo" width="120">
			<h1 style="color:white">Hola! {{ $clientName }}</h1>
			<p style="color:#7cb2fb">El día de hoy {{ $clientDay }}/{{ $month }}/{{ $year }} ha vencido su pago, su cuenta tiene un saldo pendiente de {{ $deuda }} </p>
			<p style="color:#7cb2fb">Favor de realizar el pago correspondiente</p>
			<p style="color:#7cb2fb">Una vez transcurridos 5 días despues del día de vencimiento el servicio quedara temporalmente suspendido</p>
			<p style="color:#7cb2fb">Gracias por su tiempo, nos complace continuar brindando un servicio que le encantará</p>
			<br>
			<p style="font-size: 10px; color: white; font-style: italic;">Soporte Digital Admin Track</p>
		 
	</div>
		<table>
		<tr>
			<td></td>
		</tr>
	</table> 
	</style>
</body>
</html>