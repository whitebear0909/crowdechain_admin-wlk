<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Walkabout</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
  <style type="text/css">
  /**
  * Avoid browser level font resizing.
  * 1. Windows Mobile
  * 2. iOS / OSX
  */
  body,
  table,
  td,
  a {
    -ms-text-size-adjust: 100%; /* 1 */
    -webkit-text-size-adjust: 100%; /* 2 */
  }
  /**
  * Remove extra space added to tables and cells in Outlook.
  */
  table,
  td {
    mso-table-rspace: 0pt;
    mso-table-lspace: 0pt;
  }
  /**
  * Better fluid images in Internet Explorer.
  */
  img {
    -ms-interpolation-mode: bicubic;
  }
  /**
  * Remove blue links for iOS devices.
  */
  a[x-apple-data-detectors] {
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
    color: inherit !important;
    text-decoration: none !important;
  }

  /**
  * Fix centering issues in Android 4.4.
  */
  div[style*="margin: 16px 0;"] {
    margin: 0 !important;
  }
  body {
    width: 100% !important;
    height: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
  }
  table {
    border-collapse: collapse !important;
  }
  a {
    color: #1a82e2;
  }
  </style>
</head>
<body style="background-color: #e9ecef;">
  <div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
    Welcome
  </div>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td align="center" bgcolor="#e9ecef" style="padding-top: 20px;">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
        <td align="center" valign="top" width="600">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 700px;">
          <tr>
            <td align="center" valign="top" style="padding: 12px 24px; background-color: #5E7AB1;font-size: 36px;">
              <a href="" target="_blank" style="display: inline-block; color: #fff;text-decoration:none;">
              Walkabout
              </a>
            </td>
          </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 700px;">
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 0px 24px 0; font-family: Helvetica, Arial, sans-serif;">
              <h2 style="margin: 0; font-size: 20px; color: #182333; font-weight: 600; letter-spacing: -1px; line-height: 48px;"><?php echo $body['hello'].$body2['toname'] ?>,</h2>
            </td>
          </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 700px;">
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;">
              <p style="margin: 0;">
                <?php echo $body['body1']; ?>
              </p>
            </td>
          </tr>
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 24px;">
              <p style="margin: 0;">
                <strong>Name: </strong><?php echo $body2['name']; ?><br />
                <strong>Email: </strong><?php echo $body2['email']; ?><br />
                <strong>Message: </strong><?php echo $body2['message']; ?><br />
              </p>
            </td>
          </tr>
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 18px; border-bottom: 1px solid #d4dadf">
              <p style="margin: 0;">Thanks,<br> 
              The Walkabout Team</p>
            </td>
          </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td align="center" bgcolor="#e9ecef" style="padding: 12px 24px; font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
              <p style="margin: 0;"> © Copyright - Walkabout - All Rights Reserved </p>
            </td>
          </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
      </td>
    </tr>
  </table>
</body>
</html>