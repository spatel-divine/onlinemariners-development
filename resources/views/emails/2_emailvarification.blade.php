<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Online Mariners</title>
<style type="text/css">
    .btn-primary{
        text-decoration: none;color: #fff;background-color: #337ab7;border-color: #2e6da4;display: inline-block;
        margin-bottom: 0;font-weight: 400;text-align: center;white-space: nowrap;vertical-align: middle;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;background-image: none;border: 1px solid transparent;
        padding: 6px 12px;font-size: 14px;line-height: 1.42857143;border-radius: 4px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;
    }
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center"  style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Poppins; background: #03a84e;">
                            <img src="https://onlinemariners.com/public/assets/img/logo.png" alt="Creating Email Magic" width="150" height="50" style="display: block;" />
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Poppins; font-size: 18px;">
                                        <b>Welcome {{ $data['username'] }},</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding: 20px 0 30px 0; color: #153643; font-family: Poppins; font-size: 16px; line-height: 20px;">
                                        Click on below button to verify email Address
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td  align="center">
                                        <a href="{{ $data['url'] }}" class="btn-primary" style="font-family:Poppins" target="_blank">Verify Email</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td  align="center" style="padding-top: 6%;">
                                        <!-- <p>In case above link not work click on below link: </p> -->
                                        <p>Or click on below link to verify your account(In case link is not clickable copy and paste below URL in browser to verify your account.)</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td  align="center" style="padding-top: 5%;">
                                        <a href="{{ $data['url'] }}" style="font-family:Poppins';" target="_blank">{{ $data['url'] }}</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  style="padding: 30px 30px 30px 30px; background: white;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr align="center">
                                    <td style="color: #000; font-family: Poppins; font-size: 14px;" width="75%">
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