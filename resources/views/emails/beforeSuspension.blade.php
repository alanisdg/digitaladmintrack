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
	<div  style="padding: 40px 50px;
    background-color: #005ddc;
    border-radius: 5px;
    border: 1px solid #09469a;
    width: 60%;
    margin: 40px auto;"   >
		
			<h1 style="color:white">Hola! {{ $clientName }}</h1>
			<p style="color:#7cb2fb">Su cuenta tiene un saldo pendiente de {{ $deuda }}, su cuenta quedara temporalmente suspendida el día de mañana {{ $clientDay }}/{{ $month }}/{{ $year }}</p>
			<p></p>
			<p style="color:#7cb2fb">Favor de realizar el pago correspondiente para evitar la suspensión</p>
			<p style="color:#7cb2fb">Gracias por su tiempo, nos complace continuar brindando un servicio que le encantará</p>
			<br>
			<p style="font-size: 10px; color: white; font-style: italic;">Soporte Digital Admin Track</p>
		 
	</div>
	<table>
		<tr>
			<td></td>
		</tr>
	</table> 
</body>
</html>