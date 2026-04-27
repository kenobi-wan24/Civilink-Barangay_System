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
  .title { text-align: center; font-size: 20px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; border-bottom: 3px double #2D5A27; border-top: 3px double #2D5A27; padding: 10px 0; margin: 20px 0; color: #2D5A27; }
  .meta-box { text-align: right; font-size: 11px; margin-bottom: 20px; }
  .meta-box .label { text-transform: uppercase; letter-spacing: .5px; color: #666; font-size: 10px; }
  .meta-box .value { font-weight: bold; color: #2D5A27; }
  .body-text { margin: 14px 0; text-align: justify; }
  .resident-name { font-weight: bold; text-transform: uppercase; text-decoration: underline; }
  .details-box { background: #f9faf8; border: 1px solid #ddd; border-radius: 4px; padding: 12px 16px; margin: 16px 0; }
  .details-row { display: flex; justify-content: space-between; padding: 4px 0; border-bottom: 1px solid #eee; font-size: 12px; }
  .details-row:last-child { border-bottom: none; }
  .details-label { color: #666; text-transform: uppercase; font-size: 10px; }
  .details-value { font-weight: bold; color: #2D5A27; }
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

<div class="title">Solo Parent Certification</div>

<div class="meta-box">
    <div class="label">Control No.</div>
    <div class="value">{{ $req->request_code }}</div>
    <div class="label" style="margin-top:8px">Date Issued</div>
    <div class="value">{{ now()->format('F d, Y') }}</div>
</div>

<p class="body-text">TO WHOM IT MAY CONCERN:</p>

<p class="body-text">
    This is to certify that <span class="resident-name">{{ $req->resident->full_name }}</span>,
    {{ $req->resident->age }} years old, a resident of
    <strong>{{ $req->resident->purok_zone }}, Barangay Sanctuary</strong>,
    Municipality of Tampakan, Province of South Cotabato, is a
    <strong>SOLO PARENT</strong> as defined under Republic Act No. 8972,
    otherwise known as the "Solo Parents' Welfare Act of 2000."
</p>

<p class="body-text">
    Based on our barangay records and community assessment, the above-named
    individual is solely responsible for the parental care and upbringing of
    their child/children without the support of a spouse or partner.
</p>

<div class="details-box">
    <div class="details-row">
        <span class="details-label">Full Name</span>
        <span class="details-value">{{ strtoupper($req->resident->full_name) }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Civil Status</span>
        <span class="details-value">{{ strtoupper($req->resident->civil_status) }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Address</span>
        <span class="details-value">{{ $req->resident->address }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Classification</span>
        <span class="details-value">SOLO PARENT</span>
    </div>
    <div class="details-row">
        <span class="details-label">Purpose</span>
        <span class="details-value">{{ strtoupper($req->purpose) }}</span>
    </div>
</div>

<p class="body-text">
    This certification is issued upon the request of the above-named individual
    for <strong>{{ strtoupper($req->purpose) }}</strong> purposes and to avail
    of benefits under RA 8972 and for whatever legal intent it may serve.
</p>

<p class="body-text">
    Issued this <strong>{{ now()->format('jS') }}</strong> day of
    <strong>{{ now()->format('F, Y') }}</strong>.
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