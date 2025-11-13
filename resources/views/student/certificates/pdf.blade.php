<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate - {{ $course->title }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            width: 297mm;
            height: 210mm;
            position: relative;
            background: #ffffff;
            margin: 0;
            padding: 0;
            overflow: hidden;
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        /* Professional Gradient Background */
        .certificate-container {
            width: 297mm;
            height: 210mm;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #fff9f5 0%, #fff5f8 50%, #f5f8ff 100%);
            padding: 8mm;
        }

        /* Main Certificate Card */
        .certificate-card {
            width: 281mm;
            height: 194mm;
            background: white;
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            border: 2px solid #f97316;
        }

        /* Top Decorative Bar */
        .top-bar {
            height: 5mm;
            background: linear-gradient(90deg, #f97316 0%, #ec4899 50%, #8b5cf6 100%);
            position: relative;
        }

        /* Logo Watermark - Large Background */
        .logo-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            opacity: 0.04;
            z-index: 0;
            pointer-events: none;
        }
        .logo-watermark img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: grayscale(20%);
        }

        /* Decorative Border Pattern */
        .border-pattern {
            position: absolute;
            width: 80px;
            height: 80px;
            border: 3px solid;
            opacity: 0.15;
        }
        .border-tl {
            top: 12px;
            left: 12px;
            border-color: #f97316;
            border-right: none;
            border-bottom: none;
            border-radius: 15px 0 0 0;
        }
        .border-tr {
            top: 12px;
            right: 12px;
            border-color: #ec4899;
            border-left: none;
            border-bottom: none;
            border-radius: 0 15px 0 0;
        }
        .border-bl {
            bottom: 12px;
            left: 12px;
            border-color: #8b5cf6;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 15px;
        }
        .border-br {
            bottom: 12px;
            right: 12px;
            border-color: #f97316;
            border-left: none;
            border-top: none;
            border-radius: 0 0 15px 0;
        }

        /* Certificate Badge/Seal */
        .certificate-seal {
            position: absolute;
            top: 20px;
            right: 35px;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #f97316, #ec4899);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(249, 115, 22, 0.4);
            border: 3px solid white;
            z-index: 10;
        }
        .seal-inner {
            color: white;
            font-size: 36px;
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Content Area */
        .content-area {
            padding: 8px 40px 120px 40px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        /* Header Section with Logo */
        .header {
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px double #f97316;
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        .header-logo {
            display: table-cell;
            width: 160px;
            vertical-align: middle;
            text-align: left;
        }
        .header-logo img {
            max-height: 85px;
            max-width: 160px;
            object-fit: contain;
        }
        .header-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
        .header-spacer {
            display: table-cell;
            width: 160px;
        }
        .platform-name {
            font-size: 18px;
            font-weight: 700;
            color: #f97316;
            letter-spacing: 2px;
            margin-bottom: 4px;
            text-transform: uppercase;
            font-family: 'DejaVu Sans', sans-serif;
        }
        .certificate-title {
            font-size: 36px;
            font-weight: 900;
            color: #f97316;
            letter-spacing: 6px;
            text-transform: uppercase;
            line-height: 1;
            font-family: 'DejaVu Sans', sans-serif;
        }
        .subtitle {
            font-size: 11px;
            color: #6b7280;
            font-style: italic;
            margin-top: 4px;
            letter-spacing: 1px;
        }

        /* Main Content */
        .main-content {
            padding: 15px 0 4px 0;
        }
        .presented-to {
            font-size: 12px;
            color: #4b5563;
            margin-bottom: 5px;
            font-weight: 500;
            letter-spacing: 0.8px;
        }
        .student-name {
            font-size: 34px;
            font-weight: 700;
            color: #1f2937;
            margin: 5px 0 8px 0;
            font-family: 'DejaVu Sans', sans-serif;
            font-style: italic;
            position: relative;
            display: inline-block;
            padding: 0 10px;
        }
        .student-name::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #f97316, transparent);
        }

        .completion-text {
            font-size: 12px;
            color: #374151;
            line-height: 1.5;
            margin: 4px 0;
            font-family: 'DejaVu Sans', sans-serif;
        }

        .course-box {
            display: inline-block;
            background: linear-gradient(135deg, #fff7ed 0%, #fce7f3 100%);
            padding: 10px 20px;
            border-radius: 8px;
            margin: 5px 0;
            border-left: 3px solid #f97316;
            border-right: 3px solid #ec4899;
            box-shadow: 0 3px 10px rgba(249, 115, 22, 0.12);
            max-width: 85%;
        }
        .course-name {
            font-size: 24px;
            font-weight: 700;
            color: #f97316;
            line-height: 1.3;
        }

        .excellence-badge {
            display: inline-block;
            background: #f97316;
            color: white;
            padding: 5px 20px;
            border-radius: 18px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            margin-top: 4px;
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.3);
            font-family: 'DejaVu Sans', sans-serif;
        }

        .achievement-note {
            font-size: 10px;
            color: #6b7280;
            margin-top: 3px;
            font-style: italic;
            font-family: 'DejaVu Sans', sans-serif;
        }

        /* Footer Section */
        .footer-section {
            position: absolute;
            bottom: 48px;
            left: 40px;
            right: 40px;
            display: table;
            width: calc(100% - 80px);
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
            z-index: 999;
            background: white;
            height: 70px;
        }

        .footer-left {
            display: table-cell;
            width: 35%;
            text-align: left;
            vertical-align: bottom;
            padding-right: 12px;
        }
        .footer-center {
            display: table-cell;
            width: 30%;
            text-align: center;
            vertical-align: bottom;
        }
        .footer-right {
            display: table-cell;
            width: 35%;
            text-align: right;
            vertical-align: bottom;
            padding-left: 12px;
        }

        .cert-info {
            font-size: 10px;
            color: #6b7280;
            line-height: 1.5;
            font-family: 'DejaVu Sans', sans-serif;
        }
        .cert-label {
            font-size: 9px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 2px;
            font-family: 'DejaVu Sans', sans-serif;
        }
        .cert-value {
            font-weight: 700;
            color: #f97316;
            font-size: 11px;
            font-family: 'DejaVu Sans', sans-serif;
        }

        .signature-section {
            text-align: center;
            display: inline-block;
            min-width: 180px;
        }
        .signature-image {
            max-height: 40px;
            max-width: 150px;
            object-fit: contain;
            margin: 0 auto 3px;
            display: block;
        }
        .signature-line {
            width: 150px;
            border-top: 1.5px solid #1f2937;
            margin: 4px auto 5px;
        }
        .signature-name {
            font-size: 15px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
            font-family: 'DejaVu Sans', sans-serif;
        }
        .signature-title {
            font-size: 11px;
            color: #6b7280;
            font-style: normal;
            font-weight: 500;
            margin-bottom: 2px;
            font-family: 'DejaVu Sans', sans-serif;
        }
        .signature-date {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 2px;
            font-family: 'DejaVu Sans', sans-serif;
        }

        /* Decorative Stars */
        .star {
            position: absolute;
            color: #fbbf24;
            font-size: 14px;
            opacity: 0.12;
            z-index: 0;
        }
        .star-1 { top: 38px; left: 38px; }
        .star-2 { top: 38px; right: 120px; }
        .star-3 { top: 90px; left: 22px; }
        .star-4 { bottom: 95px; left: 28px; }
        .star-5 { bottom: 95px; right: 28px; }
        .star-6 { top: 65px; right: 32px; }

        /* Print Optimization */
        @media print {
            .certificate-container {
                padding: 0;
            }
            .certificate-card {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-card">
            <!-- Top Decorative Bar -->
            <div class="top-bar"></div>

            <!-- Decorative Border Patterns -->
            <div class="border-pattern border-tl"></div>
            <div class="border-pattern border-tr"></div>
            <div class="border-pattern border-bl"></div>
            <div class="border-pattern border-br"></div>

            <!-- Stars Decoration -->
            <div class="star star-1">★</div>
            <div class="star star-2">★</div>
            <div class="star star-3">★</div>
            <div class="star star-4">★</div>
            <div class="star star-5">★</div>
            <div class="star star-6">★</div>

            <!-- Logo Watermark (Large Background) -->
            @if(isset($logoPath) && $logoPath && file_exists($logoPath))
            <div class="logo-watermark">
                <img src="{{ $logoPath }}" alt="Logo Watermark">
            </div>
            @elseif(isset($logoUrl) && $logoUrl)
            <div class="logo-watermark">
                <img src="{{ $logoUrl }}" alt="Logo Watermark">
            </div>
            @endif

            <!-- Certificate Seal Badge -->
            <div class="certificate-seal">
                <div class="seal-inner">★</div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Header with Logo -->
                <div class="header">
                    <div class="header-logo">
                        @if(isset($logoPath) && $logoPath && file_exists($logoPath))
                        <img src="{{ $logoPath }}" alt="Logo">
                        @elseif(isset($logoUrl) && $logoUrl)
                        <img src="{{ $logoUrl }}" alt="Logo">
                        @endif
                    </div>

                    <div class="header-text">
                        <div class="platform-name" style="font-family: DejaVu Sans, sans-serif; color: #f97316;">
                            {{ $platformName }}
                        </div>
                        <div class="certificate-title" style="font-family: DejaVu Sans, sans-serif;">CERTIFICATE</div>
                        <div class="subtitle">of Achievement & Excellence</div>
                    </div>

                    <div class="header-spacer"></div>
                </div>

                <!-- Main Content -->
                <div class="main-content">
                    <div class="presented-to">This certificate is proudly presented to</div>

                    <div class="student-name">{{ $student->name }}</div>

                    <div class="completion-text">
                        for successfully completing the comprehensive online course
                    </div>

                    <div class="course-box">
                        <div class="course-name">{{ $course->title }}</div>
                    </div>

                    <div class="completion-text">
                        demonstrating outstanding dedication, commitment, and excellence<br>
                        in continuous professional learning and development
                    </div>

                    <div class="excellence-badge">
                        SUCCESSFULLY COMPLETED
                    </div>

                    <div class="achievement-note">
                        All course materials and assessments completed with distinction
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="footer-section">
                <div class="footer-left">
                    <div class="cert-label">Certificate Number</div>
                    <div class="cert-value">{{ $certificate->certificate_number }}</div>
                </div>

                <div class="footer-center">
                    <div class="signature-section">
                        @if(isset($signaturePath) && $signaturePath && file_exists($signaturePath))
                            <img src="{{ $signaturePath }}" alt="Signature" class="signature-image">
                        @elseif(isset($signatureUrl) && $signatureUrl)
                            <img src="{{ $signatureUrl }}" alt="Signature" class="signature-image">
                        @endif
                        <div class="signature-line"></div>
                        <div class="signature-name" style="font-family: DejaVu Sans, sans-serif; font-size: 15px; font-weight: 700; color: #1f2937;">
                            {{ $ceoName }}
                        </div>
                        <div class="signature-title" style="font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #6b7280;">CEO & Founder</div>
                        <div class="signature-date" style="font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #9ca3af;">Signed on {{ $certificate->issued_at->format('d F Y') }}</div>
                    </div>
                </div>

                <div class="footer-right">
                    <div class="cert-label">Date Issued</div>
                    <div class="cert-info">
                        <strong>{{ $certificate->issued_at->format('d F Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
