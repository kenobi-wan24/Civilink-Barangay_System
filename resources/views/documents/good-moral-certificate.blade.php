<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Times New Roman', serif; font-size: 13px; color: #1a1a1a; padding: 40px 60px; line-height: 1.7; }
  .header { text-align: center; margin-bottom: 24px; }
  .header p { font-size: 11px; }
  .header .office { font-size: 13px; font-weight: bold; text-transform: uppercase; margin: 6px 0; }
  .title { text-align: center; font-size: 20px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; border-bottom: 3px double #2D5A27; border-top: 3px double #2D5A27; padding: 10px 0; margin: 20px 0; color: #2D5A27; }
  .meta-box { text-align: right; font-size: 11px; margin-bottom: 20px; }
  .meta-box .label { text-transform: uppercase; letter-spacing: .5px; color: #666; font-size: 10px; }
  .meta-box .value { font-weight: bold; color: #2D5A27; }
  .body-text { margin: 14px 0; text-align: justify; }
  .resident-name { font-weight: bold; text-transform: uppercase; text-decoration: underline; }
  .signature-section { margin-top: 50px; text-align: center; }
  .signature-line { border-top: 1.5px solid #1a1a1a; margin: 0 auto 6px; width: 200px; }
  .signatory-name { font-weight: bold; font-size: 13px; text-transform: uppercase; }
  .signatory-title { font-size: 11px; color: #666; }
</style>
</head>
<body>

<div class="header">
    <p>Republic of the Philippines</p>
    <p>Province of South Cotabato</p>
    <p>Municipality of Tampakan</p>
    <p class="office">Office of the Punong Barangay</p>
    <p><strong>BARANGAY SANCTUARY</strong></p>
</div>

<div class="title">Certificate of Good Moral Character</div>

<div class="meta-box">
    <div class="label">Control No.</div>
    <div class="value">{{ $req->request_code }}</div>
    <div class="label" style="margin-top:8px">Date Issued</div>
    <div class="value">{{ now()->format('F d, Y') }}</div>
</div>

<p class="body-text">TO WHOM IT MAY CONCERN:</p>

<p class="body-text">
    This is to certify that <span class="resident-name">{{ $req->resident->full_name }}</span>,
    {{ $req->resident->age }} years old, {{ ucfirst($req->resident->civil_status) }},
    a resident of <strong>{{ $req->resident->purok_zone }}, Barangay Sanctuary</strong>,
    Municipality of Tampakan, Province of South Cotabato, is personally known to this office.
</p>

<p class="body-text">
    Based on available records and community knowledge, the above-named individual
    is of <strong>GOOD MORAL CHARACTER</strong>, a law-abiding citizen, and
    has no pending derogatory records or criminal complaints filed in this barangay
    as of the date of this issuance.
</p>

<p class="body-text">
    The above-named person is known to be responsible, trustworthy, and
    an upstanding member of the community.
</p>

<p class="body-text">
    This certification is issued upon the request of the above-named individual
    for <strong>{{ strtoupper($req->purpose) }}</strong> purposes and for
    whatever legal intent it may serve.
</p>

<p class="body-text">
    Issued this <strong>{{ now()->format('jS') }}</strong> day of
    <strong>{{ now()->format('F, Y') }}</strong> at Barangay Sanctuary,
    Tampakan, South Cotabato, Philippines.
</p>

<div class="signature-section">
    <div class="signature-line"></div>
    <div class="signatory-name">
        @php $captain = \App\Models\Official::where('position','like','%Captain%')->first(); @endphp
        {{ $captain?->name ?? 'HON. BARANGAY CAPTAIN' }}
    </div>
    <div class="signatory-title">Punong Barangay</div>
</div>

</body>
</html>