<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Online Mariners</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                    <tr>
                        <td align="center"  style="padding: 40px 0 30px 0;">
                           <span style="font-size: 18px;">Online Mariners</span>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 30px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 18px;">
                                        <b>Welcome {{ $data['username'] }},</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        Click on below button to verify email Address
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td  align="center">
                                        <a href="{{ $data['url'] }}" class="btn-primary" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';" target="_blank">Verify Email</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td  align="center" style="padding-top: 6%;">                                        
                                        <p>Or click on below link to verify your account(In case link is not clickable copy and paste below URL in browser to verify your account.)</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td  align="center" style="padding-top: 5%;">
                                        <a href="{{ $data['url'] }}" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';" target="_blank">{{ $data['url'] }}</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr align="center">
                                    <td style="color: #000; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                                        &reg; Online Mariners, Online Mariners 2020<br/>                                        
                                    </td>                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>