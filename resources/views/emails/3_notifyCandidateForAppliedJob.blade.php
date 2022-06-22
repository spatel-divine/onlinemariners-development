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
        font-weight: bold; font-family: Poppins; 
        background: #03a84e;
    }
    .blackborder{border:1px solid black}
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
                        <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 5%;">
                                <tr>
                                    <td style="color: #153643;text-transform: capitalize; font-family: Poppins; font-size: 18px;">
                                        <b>Dear {{ $data['candidate_name'] }},</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding: 20px 0 30px 0; color: #153643; font-family: Poppins; font-size: 16px; line-height: 20px;">
                                        <p>Employer {{ $data['employer_name'] }} consider you application and find your job application status in below table. </p>
                                        <table style="width:100%; border:1px solid gray">
                                            <tr class="blackborder">
                                                <td class="blackborder">Job Title</td>
                                                <td class="blackborder">{{ $data['job_title'] }}</td>
                                            </tr>
                                            <tr style="border:1px solid black">
                                                <td class="blackborder">Employer Name</td>
                                                <td class="blackborder">{{ $data['employer_name'] }}</td>
                                            </tr>
                                            <tr style="border:1px solid black">
                                                <td class="blackborder">Rank Postion</td>
                                                <td class="blackborder">{{ $data['rank_position'] }}</td>
                                            </tr>
                                            <tr style="border:1px solid black">
                                                <td class="blackborder">Application Status</td>
                                                <td class="blackborder">{{ $data['apply_status'] }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>  
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  style="padding: 30px 30px 30px 30px; background: #e2e2e2;">
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