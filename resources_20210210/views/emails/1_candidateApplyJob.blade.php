<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Online Mariners</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<style type="text/css">
    .logo{
        padding: 40px 0 30px 0; 
        color: #153643; font-size: 28px; 
        font-weight: bold; font-family: Arial, sans-serif; 
        background: #03a84e;
    }
</style>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center"  class="logo" class="logo">
                            <img src="https://onlinemariners.com/public/assets/img/logo.png" alt="Creating Email Magic" width="150" height="50" style="display: block;" />
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 18px;">
                                        <b>Dear {{ $data['name'] }},</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        Candidate {{ $data['candidate_name'] }} applied for the position of  {{ $data['rank_position'] }}.Currently its application status is <strong>pending</strong>. Take further steps by login with you employer account. 
                                    </td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  style="padding: 30px 30px 30px 30px; background: white;">
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