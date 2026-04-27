<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Times New Roman', serif; font-size: 13px; color: #1a1a1a; padding: 40px 60px; line-height: 1.7; }
  .header { text-align: center; margin-bottom: 24px; }
  .header p { font-size: 11px; letter-spacing: .5px; }
  .header .office { font-size: 13px; font-weight: bold; text-transform: uppercase; margin: 6px 0; }
  .title { text-align: center; font-size: 22px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; border-bottom: 3px double #2D5A27; border-top: 3px double #2D5A27; padding: 10px 0; margin: 20px 0; color: #2D5A27; }
  .meta-row { display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 11px; }
  .meta-box { text-align: right; }
  .meta-box .label { text-transform: uppercase; letter-spacing: .5px; color: #666; font-size: 10px; }
  .meta-box .value { font-weight: bold; color: #2D5A27; font-size: 12px; }
  .body-text { margin: 14px 0; text-align: justify; }
  .resident-name { font-weight: bold; text-transform: uppercase; text-decoration: underline; }
  .details-box { background: #f9faf8; border: 1px solid #ddd; border-radius: 4px; padding: 12px 16px; margin: 16px 0; }
  .details-row { display: flex; justify-content: space-between; padding: 4px 0; border-bottom: 1px solid #eee; font-size: 12px; }
  .details-row:last-child { border-bottom: none; }
  .details-label { color: #666; text-transform: uppercase; font-size: 10px; letter-spacing: .5px; }
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

<div class="title">Certificate of Residency</div>

<div class="meta-row">
    <div></div>
    <div class="meta-box">
        <div class="label">Control No.</div>
        <div class="value">{{ $req->request_code }}</div>
        <div class="label" style="margin-top:8px">Date Issued</div>
        <div class="value">{{ now()->format('F d, Y') }}</div>
    </div>
</div>

<p class="body-text">TO WHOM IT MAY CONCERN:</p>

<p class="body-text">
    This is to certify that <span class="resident-name">{{ $req->resident->full_name }}</span>,
    {{ $req->resident->age }} years old, is a bonafide resident of
    <strong>{{ $req->resident->purok_zone }}, Barangay Sanctuary</strong>,
    Municipality of Tampakan, Province of South Cotabato, Philippines.
</p>

<p class="body-text">
    The above-named individual has been residing in this barangay since
    <strong>{{ $req->resident->created_at->format('Y') }}</strong> and is
    known to be of good standing in the community.
</p>

<div class="details-box">
    <div class="details-row">
        <span class="details-label">Full Name</span>
        <span class="details-value">{{ strtoupper($req->resident->full_name) }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Date of Birth</span>
        <span class="details-value">{{ $req->resident->birthdate->format('F d, Y') }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Gender</span>
        <span class="details-value">{{ ucfirst($req->resident->gender) }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Civil Status</span>
        <span class="details-value">{{ ucfirst($req->resident->civil_status) }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Address</span>
        <span class="details-value">{{ $req->resident->address }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Purpose</span>
        <span class="details-value">{{ strtoupper($req->purpose) }}</span>
    </div>
</div>

<p class="body-text">
    This certification is issued upon the request of the above-named individual
    for <strong>{{ strtoupper($req->purpose) }}</strong> purposes and for whatever
    legal intent it may serve.
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