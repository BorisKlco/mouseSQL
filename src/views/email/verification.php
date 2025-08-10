<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verify your <?= SERVICE_NAME ?> account</title>
    <style>
        /* Basic reset for email clients */
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            color: #1f2937;
            font-family: Helvetica, Arial, sans-serif
        }

        table {
            border-collapse: collapse
        }

        img {
            border: 0;
            display: block
        }

        a {
            color: inherit;
            text-decoration: none
        }

        /* Utility */
        .container {
            width: 100%;
            max-width: 600px
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none
        }

        /* Hide preheader visually but keep for inbox preview */
        .preheader {
            display: none !important;
            visibility: hidden;
            mso-hide: all;
            font-size: 1px;
            line-height: 1px;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden
        }
    </style>
</head>

<body style="background-color:#f3f4f6;padding:24px 12px;">

    <!-- Preheader (shows in inbox preview) -->
    <div class="preheader">Verify your email to activate your <?= SERVICE_NAME ?> account.</div>

    <center>
        <table width="100%" role="presentation">
            <tr>
                <td align="center">
                    <table class="container" role="presentation" width="600" style="background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 6px 18px rgba(0,0,0,0.06);">

                        <!-- Header -->
                        <tr>
                            <td style="padding:20px 28px;background:#ffffff;border-bottom:1px solid #e6e9ee;">
                                <table width="100%" role="presentation">
                                    <tr>
                                        <td style="vertical-align:middle">
                                            <!-- logo -->
                                            <a href="<?= SERVICE_URL ?>" target="_blank" style="display:inline-block;vertical-align:middle">
                                                <img src="<?= SERVICE_LOGO ?>" alt="<?= SERVICE_NAME ?>" width="48" height="48" style="display:inline-block;vertical-align:middle;border-radius:8px;">
                                            </a>
                                            <span style="font-size:18px;font-weight:700;color:#1f2937;margin-left:12px;vertical-align:middle;display:inline-block"><?= SERVICE_NAME ?></span>
                                        </td>
                                        <td align="right" style="vertical-align:middle">
                                            <a href="<?= SERVICE_URL ?>" style="font-size:14px;color:#2563eb;font-weight:600;">Visit site</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- Hero / Body -->
                        <tr>
                            <td style="padding:32px 28px;background:linear-gradient(90deg,#94a3b8 0%,#3b82f6 100%);color:#ffffff;text-align:left;">
                                <h1 style="margin:0 0 8px 0;font-size:20px;line-height:1.2;font-weight:700">Verify your email</h1>
                                <p style="margin:0;font-size:14px;line-height:1.5;opacity:0.95;max-width:520px">Hi <?= $username ?>,<br>Please confirm your email address to activate your <?= SERVICE_NAME ?> account.</p>
                            </td>
                        </tr>

                        <tr>
                            <td style="padding:28px;background:#ffffff;color:#111827;">
                                <p style="margin:0 0 18px 0;font-size:15px;line-height:1.6;color:#374151">To complete registration, click the button below.</p>

                                <!-- CTA -->
                                <p style="margin:0 0 24px 0;text-align:center">
                                    <a href="<?= $verification_link ?>" class="btn" style="background:#3b82f6;color:#ffffff;border-radius:8px;padding:12px 20px;display:inline-block;font-weight:700;">Verify Email</a>
                                </p>

                                <!-- Fallback link -->
                                <p style="font-size:13px;color:#6b7280;margin:0 0 14px 0;word-break:break-all">If the button does not work, copy and paste this URL into your browser:<br><a href="<?= $verification_link ?>" style="color:#2563eb;"><?= $verification_link ?></a></p>

                                <hr style="border:none;border-top:1px solid #eef2f7;margin:20px 0">

                                <p style="margin:0;font-size:13px;color:#6b7280;line-height:1.5">If you didn't create an account with <?= SERVICE_NAME ?>, you can safely ignore this email. For help, visit our <a href="<?= SERVICE_URL ?>/support" style="color:#2563eb">support page</a>.</p>
                            </td>
                        </tr>

                        <!-- Footer -->
                        <tr>
                            <td style="padding:18px 28px;background:#f9fafb;color:#6b7280;font-size:12px;border-top:1px solid #e6e9ee;">
                                <table width="100%" role="presentation">
                                    <tr>
                                        <td>
                                            <strong style="color:#111827"><?= SERVICE_NAME ?></strong><br>
                                            Free PostgreSQL database instances for developers
                                        </td>
                                        <td align="right" style="vertical-align:middle">
                                            <span style="display:inline-block;margin-bottom:6px">2025 <?= SERVICE_NAME ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>

                    <!-- Small legal / plain text -->
                    <table class="container" role="presentation" width="600" style="max-width:600px;margin-top:12px;">
                        <tr>
                            <td style="font-size:12px;color:#9ca3af;text-align:center;padding:6px 8px">
                                This message was sent from <a href="<?= SERVICE_URL ?>" style="color:#9ca3af"><?= SERVICE_NAME ?></a>.
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
    </center>

</body>

</html>