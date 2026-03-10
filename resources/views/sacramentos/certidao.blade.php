<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1e293b;
            font-size: 13px;
            margin: 0;
            padding: 0;
        }

        .page {
            padding: 48px;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #1a3a5c;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .cross {
            font-size: 36px;
            color: #d4af37;
        }

        .parish-name {
            font-size: 22px;
            font-weight: bold;
            color: #1a3a5c;
            margin: 8px 0 4px;
        }

        .parish-sub {
            font-size: 12px;
            color: #64748b;
        }

        .cert-title {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #1a3a5c;
            margin: 24px 0 16px;
            text-align: center;
        }

        .cert-body {
            line-height: 2;
            text-align: justify;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .cert-body strong {
            color: #1a3a5c;
        }

        .details {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .detail-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .detail-label {
            display: table-cell;
            width: 35%;
            font-weight: bold;
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            display: table-cell;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
        }

        .signature {
            display: inline-block;
            width: 220px;
            border-top: 1px solid #1a3a5c;
            padding-top: 8px;
            font-size: 12px;
            color: #64748b;
            margin: 0 30px;
        }

        .date-line {
            text-align: center;
            margin: 30px 0;
            color: #64748b;
            font-size: 12px;
        }

        .seal {
            text-align: center;
            margin: 10px 0;
            font-size: 48px;
            opacity: 0.15;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="header">
            <div class="cross">✝</div>
            <div class="parish-name">Paróquia Digital</div>
            <div class="parish-sub">Diocese — Secretaria Paroquial</div>
        </div>

        <div class="cert-title">Certidão de {{ $sacramento->tipo_label }}</div>

        <div class="cert-body">
            Certifico e dou fé que nos registros desta Paróquia consta que
            <strong>{{ strtoupper($sacramento->fiel->nome_completo) }}</strong>,
            @if($sacramento->fiel->data_nascimento)
            nascido(a) em {{ $sacramento->fiel->data_nascimento->format('d') }} de
            {{ $sacramento->fiel->data_nascimento->translatedFormat('F') }} de
            {{ $sacramento->fiel->data_nascimento->format('Y') }},
            @endif
            recebeu o sacramento de <strong>{{ $sacramento->tipo_label }}</strong>
            no dia <strong>{{ $sacramento->data->format('d') }}</strong> de
            <strong>{{ $sacramento->data->translatedFormat('F') }}</strong> de
            <strong>{{ $sacramento->data->format('Y') }}</strong>,
            @if($sacramento->local) na <strong>{{ $sacramento->local }}</strong>, @endif
            @if($sacramento->celebrante) administrado por <strong>{{ $sacramento->celebrante }}</strong>. @endif
        </div>

        <div class="details">
            @if($sacramento->padrinho || $sacramento->madrinha)
            <div class="detail-row">
                <div class="detail-label">Padrinho</div>
                <div class="detail-value">{{ $sacramento->padrinho ?? '—' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Madrinha</div>
                <div class="detail-value">{{ $sacramento->madrinha ?? '—' }}</div>
            </div>
            @endif
            @if($sacramento->conjuge)
            <div class="detail-row">
                <div class="detail-label">Cônjuge</div>
                <div class="detail-value">{{ $sacramento->conjuge }}</div>
            </div>
            @endif
            @if($sacramento->numero_registro)
            <div class="detail-row">
                <div class="detail-label">Nº Registro</div>
                <div class="detail-value">{{ $sacramento->numero_registro }}</div>
            </div>
            @endif
            @if($sacramento->livro)
            <div class="detail-row">
                <div class="detail-label">Livro / Folha / Termo</div>
                <div class="detail-value">{{ $sacramento->livro }} / {{ $sacramento->folha }} / {{ $sacramento->termo }}
                </div>
            </div>
            @endif
        </div>

        <div class="date-line">
            Emitido em {{ now()->format('d') }} de {{ now()->translatedFormat('F') }} de {{ now()->format('Y') }}.
        </div>

        <div class="seal">✝</div>

        <div class="footer">
            <div class="signature">
                <br>Pároco
            </div>
            <div class="signature">
                <br>Secretário(a) Paroquial
            </div>
        </div>
    </div>
</body>

</html>