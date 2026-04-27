<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Times New Roman', serif;
    font-size: 13px;
    color: #1a1a1a;
    padding: 40px 60px;
    line-height: 1.6;
  }
  .header { text-align: center; margin-bottom: 24px; }
  .header p { font-size: 11px; letter-spacing: .5px; }
  .header .office {
    font-size: 13px;
    font-weight: bold;
    text-transform: uppercase;
    margin: 6px 0;
  }
  .title {
    text-align: center;
    font-size: 22px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-bottom: 3px double #2D5A27;
    border-top: 3px double #2D5A27;
    padding: 10px 0;
    margin: 20px 0;
    color: #2D5A27;
  }
  .meta-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    font-size: 11px;
  }
  .meta-box { text-align: right; }
  .meta-box .label {
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #666;
    font-size: 10px;
  }
  .meta-box .value {
    font-weight: bold;
    color: #2D5A27;
    font-size: 12px;
  }
  .resident-photo {
    float: left;
    width: 100px;
    height: 120px;
    border: 1px solid #ccc;
    margin-right: 20px;
    margin-bottom: 10px;
    overflow: hidden;
  }
  .resident-photo img { width: 100%; height: 100%; object-fit: cover; }
  .resident-photo-placeholder {
    width: 100%;
    height: 100%;
    background: #f5f5f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: bold;
    color: #ccc;
  }
  .clearfix::after { content: ''; display: table; clear: both; }
  .body-text { margin: 16px 0; text-align: justify; }
  .resident-name {
    font-weight: bold;
    text-transform: uppercase;
    text-decoration: underline;
  }
  .details-box {
    background: #f9faf8;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 12px 16px;
    margin: 16px 0;
  }
  .details-row {
    display: flex;
    justify-content: space-between;
    padding: 4px 0;
    border-bottom: 1px solid #eee;
    font-size: 12px;
  }
  .details-row:last-child { border-bottom: none; }
  .details-label { color: #666; text-transform: uppercase; font-size: 10px; letter-spacing: .5px; }
  .details-value { font-weight: bold; color: #2D5A27; }
  .signature-section {
    margin-top: 50px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
  }
  .thumb-mark {
    text-align: center;
    width: 120px;
  }
  .thumb-box {
    width: 80px;
    height: 80px;
    border: 1px solid #ccc;
    border-radius: 50%;
    margin: 0 auto 6px;
    background: #f9f9f9;
  }
  .thumb-label { font-size: 9px; text-transform: uppercase; letter-spacing: .5px; color: #999; }
  .signatory { text-align: center; min-width: 200px; }
  .signature-line {
    border-top: 1.5px solid #1a1a1a;
    margin-bottom: 6px;
    width: 200px;
  }
  .signatory-name { font-weight: bold; font-size: 13px; text-transform: uppercase; }
  .signatory-title { font-size: 11px; color: #666; }
  .or-number {
    font-size: 10px;
    color: #999;
    text-align: right;
    margin-top: 8px;
  }
  .watermark {
    position: fixed;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-30deg);
    font-size: 80px;
    font-weight: bold;
    color: rgba(45, 90, 39, 0.05);
    text-transform: uppercase;
    letter-spacing: 10px;
    pointer-events: none;
    z-index: -1;
  }
</style>
</head>
<body>

<div class="watermark">OFFICIAL</div>

<div class="header">
    <p>Republic of the Philippines</p>
    <p>Province of South Cotabato</p>
    <p>Municipality of Tampakan</p>
    <p class="office">Office of the Punong Barangay</p>
    <p><strong>BARANGAY SANCTUARY</strong></p>
</div>

<div class="title">Barangay Clearance</div>

<div class="meta-row">
    <div></div>
    <div class="meta-box">
        <div class="label">Control No.</div>
        <div class="value">{{ $req->request_code }}</div>
        <div class="label" style="margin-top:8px">Date Issued</div>
        <div class="value">{{ now()->format('F d, Y') }}</div>
    </div>
</div>

<div class="clearfix">
    <div class="resident-photo">
        @if($req->resident->profile_picture)
            <img src="{{ storage_path('app/public/' . $req->resident->profile_picture) }}"
                 alt="Photo"/>
        @else
            <div class="resident-photo-placeholder">
                {{ strtoupper(substr($req->resident->first_name,0,1).substr($req->resident->last_name,0,1)) }}
            </div>
        @endif
    </div>

    <p class="body-text">TO WHOM IT MAY CONCERN:</p>

    <p class="body-text">
        This is to certify that
        <span class="resident-name">{{ $req->resident->full_name }}</span>,
        {{ $req->resident->age }} years old, {{ ucfirst($req->resident->civil_status) }},
        Filipino citizen, whose thumb mark and signature appear below, is a bona fide
        resident of Barangay Sanctuary, Municipality of Tampakan, Province of South Cotabato.
    </p>

    <p class="body-text">
        The above-named person is of good moral character, law-abiding citizen, and has
        no derogatory record on file in this office as of this date.
    </p>
</div>

<div class="details-box">
    <div class="details-row">
        <span class="details-label">Purpose</span>
        <span class="details-value">{{ strtoupper($req->purpose) }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Civil Status</span>
        <span class="details-value">{{ strtoupper($req->resident->civil_status) }}</span>
    </div>
    <div class="details-row">
        <span class="details-label">Address</span>
        <span class="details-value">{{ $req->resident->purok_zone }}, Barangay Sanctuary</span>
    </div>
</div>

<p class="body-text">
    Issued this <strong>{{ now()->format('jS') }}</strong> day of
    <strong>{{ now()->format('F, Y') }}</strong> upon the request of the interested
    party for whatever legal purposes it may serve.
</p>

<div class="signature-section">
    <div class="thumb-mark">
        <div class="thumb-box"></div>
        <div class="thumb-label">Left Thumb Mark</div>
    </div>

    <div class="signatory">
        <div class="signature-line"></div>
        <div class="signatory-name">
            @php $captain = \App\Models\Official::where('position','like','%Captain%')->first(); @endphp
            {{ $captain?->name ?? 'HON. BARANGAY CAPTAIN' }}
        </div>
        <div class="signatory-title">Punong Barangay</div>
    </div>
</div>

<div class="or-number">
    Not valid without official dry seal &nbsp;|&nbsp;
    Issued by: {{ $req->approvedBy?->name ?? auth()->user()->name }}
</div>

</body>
</html>