<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Confirmation de rendez-vous') }}</title>
</head>
<body style="margin:0;padding:24px;background:#f8fafc;color:#0f172a;font-family:Arial,sans-serif;">
    <div style="max-width:640px;margin:0 auto;background:#ffffff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;">
        <div style="background:#3b82f6;color:#ffffff;padding:18px 22px;">
            <h2 style="margin:0;font-size:20px;">{{ __('Rendez-vous confirmé') }}</h2>
        </div>

        <div style="padding:22px;">
            <p style="margin:0 0 14px;font-size:15px;line-height:1.6;">
                {{ __('Bonjour') }} {{ $rendezVous->patient->name ?? __('Patient') }},
            </p>

            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;">
                {{ __('Votre rendez-vous a été confirmé. Voici les détails :') }}
            </p>

            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <tbody>
                    <tr>
                        <td style="padding:10px 0;border-bottom:1px solid #e2e8f0;color:#64748b;">{{ __('Médecin') }}</td>
                        <td style="padding:10px 0;border-bottom:1px solid #e2e8f0;text-align:right;">{{ $rendezVous->medecin->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;border-bottom:1px solid #e2e8f0;color:#64748b;">{{ __('Service') }}</td>
                        <td style="padding:10px 0;border-bottom:1px solid #e2e8f0;text-align:right;">{{ $rendezVous->service->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;color:#64748b;">{{ __('Date et heure') }}</td>
                        <td style="padding:10px 0;text-align:right;">{{ optional($rendezVous->date_heure)->format('d/m/Y H:i') }}</td>
                    </tr>
                </tbody>
            </table>

            <p style="margin:16px 0 0;font-size:13px;color:#475569;line-height:1.6;">
                {{ __('Merci de vous présenter quelques minutes avant l\'heure prévue.') }}
            </p>
        </div>
    </div>
</body>
</html>

