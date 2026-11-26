<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapist Dashboard - CLAIRE</title>
    @vite('resources/js/app.js')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --white: #ffffff;
            --soft: #f6f8f6;
            --line: #edf0ed;
            --ink: #1f2a24;
            --muted: #8d9690;
            --brand: #2b7a5f;
            --card: #4a8f7b;
            --lime: #a6d65e;
            --lime-ink: #37652a;
            --coral: #ee8b7c;
            --violet: #8c8cf0;
            --leaf: #9bd672;
            --link: #ee6a56;
            --wait: #a16207;
            --wait-bg: #fdf0cf;
            --ok: #1f6b3a;
            --ok-bg: #dcf0e1;
            --done: #4a49b8;
            --done-bg: #e6e6fb;
            --bad: #b03a2e;
            --bad-bg: #fbe3df;
            --shadow: 0 8px 24px rgba(40, 90, 65, 0.08);
            --font: "Plus Jakarta Sans", system-ui, -apple-system, "Segoe UI", Arial, sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 24px;
        }

        [hidden] {
            display: none !important;
        }

        body {
            font-family: var(--font);
            font-size: 14px;
            color: var(--ink);
            background: linear-gradient(135deg, #e3eee6 0%, #f1f6f2 50%, #e0ece4 100%);
            min-height: 100vh;
            padding: 24px;
        }

        button,
        input,
        textarea {
            font-family: inherit;
        }

        :focus-visible {
            outline: 2px solid var(--brand);
            outline-offset: 2px;
        }

        button.is-loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .ic {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        /* ================= SHELL ================= */

        .shell {
            max-width: 1560px;
            margin: auto;
            min-height: calc(100vh - 48px);
            background: var(--white);
            border-radius: 22px;
            box-shadow: 0 20px 60px rgba(40, 90, 65, 0.1);
            display: grid;
            grid-template-columns: 92px minmax(0, 1fr) 350px;
            overflow: hidden;
            overflow: clip;
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            position: sticky;
            top: 24px;
            align-self: start;
            height: calc(100vh - 48px);
            z-index: 5;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 36px 0 30px;
            gap: 34px;
        }

        .logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--brand);
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 20px;
        }

        .side-nav {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .side-nav a,
        .logout {
            position: relative;
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border: none;
            border-radius: 12px;
            background: transparent;
            color: #a3aba5;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .side-nav a:hover,
        .logout:hover {
            background: var(--soft);
            color: var(--brand);
        }

        .side-nav a.active {
            color: var(--brand);
            background: #e8f4dc;
        }

        .logout:hover {
            color: var(--bad);
        }

        .side-nav a::after,
        .logout::after {
            content: attr(data-label);
            position: absolute;
            left: calc(100% + 10px);
            top: 50%;
            transform: translateY(-50%) translateX(-4px);
            padding: 6px 11px;
            border-radius: 8px;
            background: var(--ink);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: 0.15s;
            z-index: 30;
        }

        .side-nav a:hover::after,
        .logout:hover::after {
            opacity: 1;
            transform: translateY(-50%);
        }

        .nav-badge {
            position: absolute;
            top: 2px;
            right: 0;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 99px;
            background: var(--link);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            display: grid;
            place-items: center;
            border: 2px solid #fff;
        }

        .sidebar form {
            margin-top: auto;
        }

        /* ================= MAIN ================= */

        .main {
            padding: 38px 30px 40px 18px;
            min-width: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .header h1 {
            font-size: 30px;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .header p {
            margin-top: 6px;
            color: var(--muted);
            font-size: 15px;
        }

        .header .clock {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 12px;
            border-radius: 999px;
            background: var(--soft);
            border: 1px solid var(--line);
            color: var(--brand);
            font-size: 12.5px;
            font-weight: 600;
        }

        .search-box {
            flex: 0 1 420px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 16px 0 20px;
            height: 54px;
            background: var(--soft);
            border: 1px solid transparent;
            border-radius: 14px;
            color: var(--muted);
            transition: 0.2s;
        }

        .search-box:focus-within {
            background: #fff;
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(43, 122, 95, 0.1);
        }

        .search-box input {
            flex: 1;
            min-width: 0;
            border: none;
            background: transparent;
            outline: none;
            font-size: 14.5px;
            color: var(--ink);
        }

        .search-box kbd {
            padding: 2px 8px;
            border-radius: 6px;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--muted);
            font-family: inherit;
            font-size: 12px;
            font-weight: 600;
        }

        .search-note {
            margin-bottom: 18px;
            padding: 14px 18px;
            border-radius: 12px;
            background: var(--wait-bg);
            color: var(--wait);
            font-size: 13px;
            font-weight: 500;
        }

        /* RINGKASAN CEPAT */

        .quick {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 24px;
        }

        .quick a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 14px;
            border: 1px solid var(--line);
            background: var(--soft);
            color: var(--ink);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .quick a:hover {
            background: #fff;
            box-shadow: var(--shadow);
            transform: translateY(-2px);
        }

        .quick a b {
            font-size: 20px;
            color: var(--brand);
        }

        .quick a.warn b {
            color: var(--wait);
        }

        /* ================= ALERT ================= */

        .alert {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            padding: 13px 17px;
            margin-bottom: 18px;
            border-radius: 12px;
            font-size: 13px;
            border-left: 4px solid;
            transition: opacity 0.4s;
        }

        .alert.success {
            background: var(--ok-bg);
            color: var(--ok);
            border-color: var(--ok);
        }

        .alert.error {
            background: var(--bad-bg);
            color: var(--bad);
            border-color: var(--bad);
        }

        .alert-close {
            border: none;
            background: transparent;
            color: inherit;
            font-size: 18px;
            line-height: 1;
            cursor: pointer;
            opacity: 0.7;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* ================= KARTU UMUM ================= */

        .box {
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 26px 28px;
        }

        .box-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .box-title h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .count-pill {
            padding: 6px 13px;
            border-radius: 999px;
            background: var(--wait-bg);
            color: var(--wait);
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .count-pill.green {
            background: var(--ok-bg);
            color: var(--ok);
        }

        .top-row {
            display: grid;
            grid-template-columns: minmax(0, 1.55fr) minmax(0, 1fr);
            gap: 24px;
            align-items: start;
            margin-bottom: 26px;
        }

        /* AVATAR: huruf inisial di bawah, foto menutupi di atasnya */

        .avatar {
            position: relative;
            overflow: hidden;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 700;
            font-size: 17px;
            flex-shrink: 0;
        }

        .avatar img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .person {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .person b {
            display: block;
            font-size: 15px;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .person small {
            display: block;
            margin-top: 2px;
            color: var(--muted);
            font-size: 12.5px;
            overflow-wrap: anywhere;
        }

        /* ================= PEKERJAAN MASUK (GESER KE SAMPING) ================= */

        .incoming-section {
            min-width: 0;
        }

        .title-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .slider-btns {
            display: flex;
            gap: 6px;
        }

        .slider-btn {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: #fff;
            color: var(--brand);
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            transition: 0.2s;
        }

        .slider-btn:hover {
            background: var(--brand);
            color: #fff;
        }

        .incoming-track {
            display: flex;
            align-items: stretch;
            gap: 14px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding: 4px 2px 14px;
            scrollbar-width: thin;
        }

        .incoming-track .incoming-card {
            flex: 0 0 300px;
            scroll-snap-align: start;
            display: flex;
            flex-direction: column;
            padding: 18px;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--soft);
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .incoming-track .incoming-card:hover {
            background: #fff;
            box-shadow: var(--shadow);
            transform: translateY(-3px);
        }

        .job-info {
            display: grid;
            gap: 9px;
            margin: 16px 0;
            padding: 14px 0;
            border-top: 1px dashed var(--line);
            border-bottom: 1px dashed var(--line);
        }

        .job-info div {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-size: 13px;
        }

        .job-info span {
            color: var(--muted);
        }

        .job-info b {
            font-weight: 600;
            text-align: right;
            overflow-wrap: anywhere;
        }

        .incoming-bottom {
            margin-top: auto;
        }

        .assignment-status {
            display: inline-block;
            margin-bottom: 8px;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .assignment-status.pending {
            background: var(--wait-bg);
            color: var(--wait);
        }

        .assignment-status.rejected {
            background: var(--bad-bg);
            color: var(--bad);
        }

        .assignment-actions {
            display: flex;
            gap: 9px;
            margin-top: 10px;
        }

        .btn-accept,
        .btn-reject {
            flex: 1;
            padding: 11px;
            border: none;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-accept {
            background: var(--lime);
            color: var(--lime-ink);
        }

        .btn-reject {
            background: var(--bad-bg);
            color: var(--bad);
        }

        .btn-accept:hover,
        .btn-reject:hover {
            opacity: 0.85;
        }

        .reject-reason {
            width: 100%;
            margin-top: 10px;
            padding: 11px 12px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: #fff;
            font-size: 12.5px;
            color: var(--ink);
            resize: none;
        }

        .reject-reason:focus {
            outline: none;
            border-color: var(--brand);
        }

        .rejection-info {
            margin-top: 8px;
            padding: 12px;
            border-radius: 10px;
            background: var(--bad-bg);
            color: var(--bad);
            font-size: 12.5px;
            line-height: 1.7;
        }

        .empty-incoming {
            padding: 34px 28px;
            background: var(--soft);
            border-radius: 12px;
            color: var(--muted);
            text-align: center;
            font-size: 13px;
        }

        /* ================= KARTU HIJAU (PEKERJAAN TERDEKAT) ================= */

        .feature-wrap {
            min-width: 0;
        }

        .feature {
            position: relative;
            overflow: hidden;
            padding: 28px;
            border-radius: 16px;
            background: linear-gradient(145deg, #55a08a 0%, var(--card) 55%, #3f7f6c 100%);
            color: #fff;
            box-shadow: 0 14px 30px rgba(74, 143, 123, 0.28);
        }

        .feature::after {
            content: "";
            position: absolute;
            right: -70px;
            bottom: -90px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .feature>* {
            position: relative;
            z-index: 1;
        }

        .feature-static {
            min-height: 300px;
        }

        .feature-top {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .feature-top .avatar {
            background: rgba(255, 255, 255, 0.25);
            width: 52px;
            height: 52px;
        }

        .feature-top b {
            display: block;
            font-size: 16px;
            font-weight: 600;
        }

        .feature-top small,
        .feature .label {
            color: rgba(255, 255, 255, 0.72);
            font-size: 13px;
        }

        .feature .label {
            display: block;
            margin-top: 22px;
        }

        .feature .value {
            display: block;
            margin-top: 4px;
            font-size: 16px;
            font-weight: 600;
        }

        .feature-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .feature-badge {
            margin-left: auto;
            padding: 5px 11px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.2);
            font-size: 11.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .feature-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 26px;
        }

        .btn-lime {
            flex: 1;
            display: block;
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            background: var(--lime);
            color: var(--lime-ink);
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-lime:hover {
            opacity: 0.9;
        }

        .btn-round {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.45);
            display: grid;
            place-items: center;
            color: #fff;
            text-decoration: none;
        }

        .btn-round:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .feature-empty {
            margin-top: 22px;
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            line-height: 1.6;
        }

        /* TUMPUKAN KARTU */

        .stack {
            position: relative;
            height: 382px;
        }

        .stack-card {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 340px;
            display: flex;
            flex-direction: column;
            transform-origin: bottom center;
            transition: transform 0.35s ease, opacity 0.35s ease, filter 0.35s ease;
        }

        .stack-card .feature-actions {
            margin-top: auto;
        }

        .stack-card[data-pos="0"] {
            z-index: 3;
            transform: none;
        }

        .stack-card[data-pos="1"] {
            z-index: 2;
            transform: translateY(15px) scale(0.95);
            filter: brightness(0.93);
            pointer-events: none;
        }

        .stack-card[data-pos="2"] {
            z-index: 1;
            transform: translateY(30px) scale(0.9);
            filter: brightness(0.86);
            pointer-events: none;
        }

        .stack-card[data-pos="3"],
        .stack-card[data-pos="4"] {
            z-index: 0;
            transform: translateY(30px) scale(0.9);
            opacity: 0;
            pointer-events: none;
        }

        .stack-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-top: 6px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
        }

        /* ================= CHAT CUSTOMER (RINGKAS) ================= */

        .chat-section {
            margin-bottom: 26px;
            padding: 18px 20px 8px;
        }

        .chat-section .box-title {
            margin-bottom: 8px;
        }

        .chat-section .box-title h2 {
            font-size: 17px;
        }

        .chat-list {
            display: flex;
            flex-direction: column;
            max-height: 290px;
            overflow-y: auto;
            margin: 0 -8px;
            padding: 0 8px;
            scrollbar-width: thin;
        }

        .chat-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 8px;
            border-bottom: 1px solid var(--line);
            border-radius: 10px;
            color: var(--ink);
            text-decoration: none;
            transition: background 0.15s;
        }

        .chat-item:last-child {
            border-bottom: none;
        }

        .chat-item:hover {
            background: #f3faf4;
        }

        .chat-item .avatar {
            width: 38px;
            height: 38px;
            font-size: 15px;
        }

        .chat-info {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .chat-info strong {
            font-size: 13.5px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-info span {
            font-size: 12px;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-side {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .chat-side time {
            font-size: 11.5px;
            color: var(--muted);
        }

        .chat-go {
            width: 30px;
            height: 30px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #e6f7e9;
            color: #00880f;
            transition: 0.15s;
        }

        .chat-go .ic {
            width: 15px;
            height: 15px;
        }

        .chat-item:hover .chat-go {
            background: #00a94f;
            color: #fff;
        }

        .chat-empty {
            padding: 22px 10px;
            text-align: center;
            color: var(--muted);
            font-size: 13px;
        }

        .chat-empty p {
            margin-bottom: 3px;
            font-weight: 600;
            color: var(--ink);
        }

        .chat-empty small {
            font-size: 12px;
        }

        @media (max-width: 500px) {
            .chat-side time {
                display: none;
            }
        }

        /* ================= KALENDER ================= */

        .calendar-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 20px;
        }

        .calendar-top h2 {
            font-size: 20px;
            font-weight: 600;
        }

        .month-navigation {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .month-navigation a {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--line);
            border-radius: 10px;
            color: var(--brand);
            text-decoration: none;
            font-size: 20px;
            transition: 0.2s;
        }

        .month-navigation a:hover {
            background: var(--brand);
            color: #fff;
        }

        .month-navigation a.today-btn {
            width: auto;
            padding: 0 14px;
            font-size: 12.5px;
            font-weight: 600;
        }

        .month-name {
            min-width: 130px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 8px;
        }

        .weekday {
            padding: 8px 4px;
            color: var(--muted);
            text-align: center;
            font-size: 13px;
            font-weight: 500;
        }

        .calendar-day {
            min-width: 0;
            min-height: 150px;
            padding: 8px;
            border-radius: 12px;
            background: var(--soft);
        }

        .calendar-day.is-today {
            background: #fff;
            box-shadow: inset 0 0 0 2px var(--brand);
        }

        .calendar-day.other-month {
            background: transparent;
            border: 1px dashed var(--line);
        }

        .day-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .day-name {
            display: none;
            font-size: 13.5px;
            font-weight: 600;
        }

        .day-number {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 12.5px;
            font-weight: 600;
            color: #5b665f;
        }

        .other-month .day-number {
            opacity: 0.45;
        }

        .day-number.today {
            background: var(--brand);
            color: #fff;
        }

        .empty-day {
            color: #c4cbc6;
            font-size: 12px;
        }

        .calendar-empty-note {
            margin-top: 16px;
            padding: 16px;
            border-radius: 12px;
            background: var(--soft);
            color: var(--muted);
            text-align: center;
            font-size: 13px;
        }

        .booking-event {
            padding: 9px 10px;
            margin-bottom: 7px;
            border-radius: 8px;
            overflow: hidden;
            color: #fff;
        }

        .booking-event.ev-pending {
            background: var(--coral);
        }

        .booking-event.ev-rejected {
            background: #d9604f;
        }

        .booking-event.ev-approved {
            background: var(--leaf);
            color: var(--lime-ink);
        }

        .booking-event.ev-completed {
            background: var(--violet);
        }

        .event-time {
            font-size: 11.5px;
            font-weight: 700;
            opacity: 0.9;
        }

        .event-treatment {
            margin-top: 2px;
            font-size: 12.5px;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .event-customer {
            margin-top: 2px;
            font-size: 11.5px;
            opacity: 0.85;
            overflow-wrap: anywhere;
        }

        .event-status {
            display: inline-block;
            margin-top: 6px;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
            line-height: 1.3;
            background: rgba(255, 255, 255, 0.3);
            color: inherit;
        }

        .booking-details {
            margin-top: 8px;
            padding-top: 7px;
            border-top: 1px dashed rgba(255, 255, 255, 0.5);
        }

        .ev-approved .booking-details {
            border-color: rgba(55, 101, 42, 0.35);
        }

        .booking-details summary {
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
        }

        .details-content {
            margin-top: 8px;
            font-size: 11.5px;
            line-height: 1.8;
            overflow-wrap: anywhere;
        }

        .btn-complete {
            width: 100%;
            margin-top: 8px;
            padding: 8px 6px;
            border: none;
            border-radius: 6px;
            background: #fff;
            color: var(--lime-ink);
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-complete:hover {
            opacity: 0.88;
        }

        .already-completed {
            display: block;
            margin-top: 8px;
            font-size: 11.5px;
            font-weight: 700;
        }

        .calendar-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 18px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--muted);
            font-size: 12.5px;
        }

        .legend-dot {
            width: 11px;
            height: 11px;
            border-radius: 3px;
        }

        .legend-approved {
            background: var(--leaf);
        }

        .legend-completed {
            background: var(--violet);
        }

        /* ================= KOLOM KANAN ================= */

        .right {
            padding: 38px 30px 40px 12px;
            display: flex;
            flex-direction: column;
            gap: 28px;
            min-width: 0;
        }

        .right-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .bell {
            position: relative;
            color: #5b665f;
            display: grid;
            place-items: center;
            text-decoration: none;
        }

        .bell.has-new::after {
            content: "";
            position: absolute;
            top: -1px;
            right: 0;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--link);
            border: 2px solid #fff;
        }

        .profile-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--ink);
            text-decoration: none;
            font-weight: 600;
            font-size: 13.5px;
            min-width: 0;
        }

        .profile-link .avatar {
            width: 36px;
            height: 36px;
            font-size: 14px;
            background: var(--brand);
        }

        .profile-link span {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .right-title {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 14px;
        }

        .right-title h3 {
            font-size: 17px;
            font-weight: 600;
        }

        .right-title a {
            color: var(--link);
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
        }

        .panel {
            padding: 20px;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: #fff;
        }

        .availability-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .availability {
            padding: 7px 13px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .availability.active {
            background: var(--ok-bg);
            color: var(--ok);
        }

        .availability.inactive {
            background: var(--bad-bg);
            color: var(--bad);
        }

        .availability-button {
            padding: 10px 15px;
            border: none;
            border-radius: 10px;
            background: var(--brand);
            color: #fff;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .availability-button:hover {
            opacity: 0.88;
        }

        .stat-row+.stat-row {
            margin-top: 16px;
        }

        .stat-line {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            font-size: 13.5px;
            color: #6f7a73;
            margin-bottom: 7px;
        }

        .stat-line b {
            font-size: 22px;
            font-weight: 700;
            color: var(--ink);
        }

        .bar {
            height: 8px;
            border-radius: 99px;
            background: var(--soft);
            overflow: hidden;
        }

        .bar span {
            display: block;
            height: 100%;
            border-radius: 99px;
        }

        .bar-total span {
            background: var(--brand);
        }

        .bar-pending span {
            background: var(--coral);
        }

        .bar-approved span {
            background: var(--leaf);
        }

        .bar-done span {
            background: var(--violet);
        }

        .today-item {
            padding: 18px 0;
            border-top: 1px solid var(--line);
        }

        .today-item:first-of-type {
            border-top: none;
            padding-top: 0;
        }

        .today-person {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .today-person .avatar {
            width: 38px;
            height: 38px;
            font-size: 14px;
        }

        .today-person b {
            display: block;
            font-size: 14.5px;
            font-weight: 600;
        }

        .today-person small {
            color: var(--muted);
            font-size: 12.5px;
        }

        .today-meta {
            display: flex;
            gap: 20px;
            margin-top: 12px;
            color: #7b857e;
            font-size: 13px;
        }

        .today-meta span {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .today-meta .ic {
            width: 17px;
            height: 17px;
        }

        .today-status {
            margin-top: 10px;
        }

        .today-empty {
            color: var(--muted);
            font-size: 13px;
            padding-bottom: 6px;
        }

        .btn-wide {
            display: block;
            margin-top: 14px;
            padding: 15px;
            text-align: center;
            background: var(--lime);
            color: var(--lime-ink);
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.2s;
        }

        .btn-wide:hover {
            opacity: 0.9;
        }

        .notif {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 18px 20px;
            border-radius: 12px;
            background: var(--soft);
            color: var(--ink);
            text-decoration: none;
        }

        .notif b {
            display: block;
            font-size: 14.5px;
            font-weight: 600;
        }

        .notif small {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 12.5px;
        }

        .notif .ic {
            color: var(--leaf);
        }

        .notif.plain {
            cursor: default;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 1350px) {
            .shell {
                grid-template-columns: 84px minmax(0, 1fr);
            }

            .right {
                grid-column: 1 / -1;
                padding: 0 30px 40px;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 24px;
            }

            .right-top {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 1100px) {
            .top-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 800px) {
            body {
                padding: 0;
            }

            .shell {
                border-radius: 0;
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: sticky;
                top: 0;
                height: auto;
                flex-direction: row;
                align-items: center;
                padding: 12px 16px;
                gap: 14px;
                overflow-x: auto;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(8px);
                border-bottom: 1px solid var(--line);
            }

            .side-nav {
                flex-direction: row;
            }

            .sidebar form {
                margin: 0 0 0 auto;
            }

            .side-nav a::after,
            .logout::after {
                display: none;
            }

            .main {
                padding: 22px 16px 24px;
            }

            .right {
                grid-template-columns: 1fr;
                padding: 0 16px 36px;
            }

            .box {
                padding: 20px 16px;
            }

            .chat-section {
                padding: 16px 14px 6px;
            }

            .search-box {
                flex-basis: 100%;
            }

            .search-box kbd {
                display: none;
            }

            .header h1 {
                font-size: 25px;
            }

            .stack {
                height: 420px;
            }

            .stack-card {
                height: 380px;
            }

            .incoming-track .incoming-card {
                flex-basis: 85%;
            }

            /* Kalender berubah jadi daftar agenda di HP */
            .calendar-grid {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .weekday {
                display: none;
            }

            .calendar-day {
                min-height: 0;
            }

            .calendar-day.is-empty:not(.is-today) {
                display: none;
            }

            .day-name {
                display: block;
            }

            .calendar-top {
                gap: 10px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
                animation: none !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>


<body>
    <div
        id="therapistDashboard"
        data-therapist-id="{{ Auth::id() }}"
        data-card-url="{{ route('therapist.assignment.card', ['id' => '__ID__']) }}"></div>

    {{-- ================= FUNGSI AVATAR (FOTO + CADANGAN HURUF) ================= --}}
    @php
    // Mencari alamat foto dari kolom "photo" di tabel users
    $photoOf = function ($u) {
    $path = $u->photo ?? null;

    if (!$path) {
    return null;
    }

    // Sudah berupa URL penuh
    if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
    return $path;
    }

    $path = ltrim($path, '/');

    // Sudah diawali "storage/"
    if (\Illuminate\Support\Str::startsWith($path, 'storage/')) {
    return asset($path);
    }

    // File ada langsung di folder public/
    if (file_exists(public_path($path))) {
    return asset($path);
    }

    // Default Laravel: storage/app/public (lewat php artisan storage:link)
    return asset('storage/' . $path);
    };

    // Membuat avatar: huruf inisial di bawah, foto menutupinya.
    // Kalau foto gagal dimuat, foto dihapus dan huruf inisial tetap tampil.
    $avatar = function ($u, $color = null) use ($photoOf) {
    $name = $u->name ?? 'Customer';
    $initial = e(strtoupper(mb_substr($name, 0, 1)));
    $style = $color ? ' style="background:' . e($color) . ';"' : '';
    $url = $photoOf($u);

    $img = $url
    ? '<img src="' . e($url) . '" alt="' . e($name) . '" onerror="this.remove()">'
    : '';

    return new \Illuminate\Support\HtmlString(
    '<div class="avatar"' . $style . '>' . $initial . $img . '</div>'
    );
    };

    // Data ringkasan yang dipakai di beberapa bagian
    $palette = ['#ee8b7c', '#8c8cf0', '#7cc255', '#5fb0d4'];
    $pendingIncoming = $incomingAssignments->where('status', 'pending')->count();
    $todayAssignments = $calendarAssignments->get(now()->format('Y-m-d'), collect());
    $chatCount = $chatAssignments->count();
    @endphp

    <div class="shell">

        <!-- ================= SIDEBAR ================= -->
        <aside class="sidebar">

            <div class="logo">C</div>

            <ul class="side-nav">
                <li>
                    <a href="{{ route('therapist.dashboard') }}" class="active" data-spy="top" data-label="Dashboard" title="Dashboard">
                        <svg class="ic" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1.5" />
                            <rect x="14" y="3" width="7" height="7" rx="1.5" />
                            <rect x="3" y="14" width="7" height="7" rx="1.5" />
                            <rect x="14" y="14" width="7" height="7" rx="1.5" />
                        </svg>
                    </a>
                </li>

                <li>
                    <a href="#chats" data-spy="#chats" data-label="Chat" title="Chat">
                        <svg class="ic" viewBox="0 0 24 24">
                            <path d="M21 12a8 8 0 0 1-11.6 7.1L3 21l1.9-5.4A8 8 0 1 1 21 12z" />
                        </svg>
                        @if($chatCount > 0)
                        <span class="nav-badge">{{ $chatCount }}</span>
                        @endif
                    </a>
                </li>

                <li>
                    <a href="#bookings" data-spy="#bookings" data-label="Jadwal" title="Jadwal">
                        <svg class="ic" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                    </a>
                </li>

                <li>
                    <a href="{{ route('therapist.profile') }}" data-label="Profil Saya" title="Profil Saya">
                        <svg class="ic" viewBox="0 0 24 24">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 21a8 8 0 0 1 16 0" />
                        </svg>
                    </a>
                </li>
            </ul>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout" data-label="Logout" title="Logout">
                    <svg class="ic" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" />
                    </svg>
                </button>
            </form>

        </aside>


        <!-- ================= MAIN CONTENT ================= -->
        <main class="main">

            <!-- HEADER -->
            <div class="header">

                <div>
                    <h1>Dashboard Terapis</h1>
                    <p>Selamat datang, {{ Auth::user()->name }}</p>
                    <span class="clock" id="clock">{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>

                <label class="search-box">
                    <svg class="ic" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="7" />
                        <path d="M21 21l-4.5-4.5" />
                    </svg>
                    <input type="search" id="searchInput" placeholder="Cari pelanggan atau treatment...">
                    <kbd>/</kbd>
                </label>

            </div>


            <!-- SESSION MESSAGE -->
            @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert error">
                <div>
                    @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            @endif


            <!-- RINGKASAN CEPAT -->
            <div class="quick">
                <a href="#bookings">
                    <b>{{ $todayAssignments->count() }}</b> jadwal hari ini
                </a>

                <a href="#incoming" class="warn">
                    <b>{{ $pendingIncoming }}</b> menunggu respons
                </a>

                <a href="#chats">
                    <b>{{ $chatCount }}</b> percakapan
                </a>
            </div>

            <div class="search-note" id="searchNote" hidden>
                Tidak ada hasil untuk "<span id="searchWord"></span>".
            </div>


            @php
            $startAt = function ($item) {
            return \Carbon\Carbon::parse($item->booking->booking_date)->format('Y-m-d')
            . ' ' . substr($item->booking->booking_time, 0, 5);
            };

            // Maksimal 5 pekerjaan terdekat yang sudah disetujui admin
            $upcomingAssignments = $calendarAssignments->flatten(1)
            ->filter(function ($item) use ($startAt) {
            return $item->status === 'accepted'
            && $item->admin_status === 'approved'
            && \Carbon\Carbon::parse($startAt($item))->gte(now());
            })
            ->sortBy(function ($item) use ($startAt) {
            return $startAt($item);
            })
            ->values()
            ->take(5);
            @endphp


            <!-- ================= PEKERJAAN MASUK + PEKERJAAN TERDEKAT ================= -->
            <div class="top-row">

                <!-- INCOMING ASSIGNMENTS -->
                <section class="box incoming-section" id="incoming">

                    <div class="box-title">

                        <h2>Pekerjaan Masuk</h2>

                        <div class="title-right">

                            <span class="count-pill">
                                {{ $pendingIncoming }}
                                Menunggu Respons
                            </span>

                            @if($incomingAssignments->count() > 1)
                            <div class="slider-btns">
                                <button type="button" class="slider-btn" id="incomingPrev" aria-label="Sebelumnya">&lsaquo;</button>
                                <button type="button" class="slider-btn" id="incomingNext" aria-label="Berikutnya">&rsaquo;</button>
                            </div>
                            @endif

                        </div>

                    </div>


                    @if($incomingAssignments->isEmpty())

                    <div class="empty-incoming">
                        Belum ada pekerjaan masuk.
                    </div>

                    @else

                    <div class="incoming-track" id="incomingTrack">

                        @foreach($incomingAssignments as $assignment)
                        @include('partials-therapist-assignment-card', [
                        'assignment' => $assignment
                        ])
                        @endforeach

                    </div>

                    @endif

                </section>


                <!-- KARTU HIJAU: PEKERJAAN TERDEKAT (BERTUMPUK) -->
                <section class="feature-wrap">

                    @if($upcomingAssignments->isNotEmpty())

                    <div class="stack" id="stack">

                        @foreach($upcomingAssignments as $item)

                        @php
                        $nextBooking = $item->booking;
                        @endphp

                        <div class="feature stack-card" data-pos="{{ $loop->index }}">

                            <div class="feature-top">
                                {!! $avatar($nextBooking->user) !!}

                                <div>
                                    <b>{{ $nextBooking->user->name ?? 'Customer' }}</b>
                                    <small>{{ $nextBooking->place === 'home' ? 'Home Service' : 'Klinik' }} · {{ $nextBooking->phone ?? '-' }}</small>
                                </div>

                                <span class="feature-badge">
                                    {{ $loop->first ? 'Terdekat' : 'Berikutnya' }}
                                </span>
                            </div>

                            <span class="label">Treatment</span>
                            <span class="value">{{ $nextBooking->treatment }}</span>

                            <div class="feature-meta">
                                <div>
                                    <span class="label">Tanggal</span>
                                    <span class="value">
                                        {{ \Carbon\Carbon::parse($nextBooking->booking_date)->translatedFormat('d F Y') }}
                                    </span>
                                </div>

                                <div>
                                    <span class="label">Jam</span>
                                    <span class="value">{{ substr($nextBooking->booking_time, 0, 5) }} WIB</span>
                                </div>
                            </div>

                            <div class="feature-actions">
                                <a href="#bookings" class="btn-lime">Lihat Jadwal</a>

                                @if($nextBooking->phone)
                                <a href="tel:{{ $nextBooking->phone }}" class="btn-round" title="Hubungi pelanggan">
                                    <svg class="ic" viewBox="0 0 24 24">
                                        <path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z" />
                                    </svg>
                                </a>
                                @endif
                            </div>

                        </div>

                        @endforeach

                    </div>

                    @if($upcomingAssignments->count() > 1)
                    <div class="stack-nav">
                        <button type="button" class="slider-btn" id="stackPrev" aria-label="Sebelumnya">&lsaquo;</button>
                        <span id="stackCounter">1 / {{ $upcomingAssignments->count() }}</span>
                        <button type="button" class="slider-btn" id="stackNext" aria-label="Berikutnya">&rsaquo;</button>
                    </div>
                    @endif

                    @else

                    <div class="feature feature-static">

                        <div class="feature-top">
                            {!! $avatar(Auth::user()) !!}

                            <div>
                                <b>{{ Auth::user()->name }}</b>
                                <small>Terapis CLAIRE</small>
                            </div>
                        </div>

                        <span class="label">Pekerjaan Terdekat</span>

                        <p class="feature-empty">
                            Belum ada jadwal mendatang yang disetujui admin.
                        </p>

                        <div class="feature-actions">
                            <a href="#bookings" class="btn-lime">Lihat Jadwal</a>
                        </div>

                    </div>

                    @endif

                </section>

            </div>


            <!-- ================= CHAT CUSTOMER ================= -->
            <section class="box chat-section" id="chats">

                <div class="box-title">
                    <h2>Chat</h2>

                    <span class="count-pill green">
                        {{ $chatCount }} Percakapan
                    </span>
                </div>

                <div class="chat-list">

                    @forelse($chatAssignments as $assignment)

                    @php
                    $booking = $assignment->booking;
                    $customer = $booking->user;
                    @endphp

                    <a href="{{ route('chat.open', $booking->id) }}" class="chat-item">

                        {!! $avatar($customer, $palette[$booking->id % 4]) !!}

                        <div class="chat-info">
                            <strong>{{ $customer->name ?? 'Customer' }}</strong>
                            <span>{{ $booking->treatment }} · {{ $booking->place === 'home' ? 'Home Service' : 'Klinik' }}</span>
                        </div>

                        <div class="chat-side">
                            <time>
                                {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M') }}
                                · {{ substr($booking->booking_time, 0, 5) }}
                            </time>

                            <span class="chat-go">
                                <svg class="ic" viewBox="0 0 24 24">
                                    <path d="M9 6l6 6-6 6" />
                                </svg>
                            </span>
                        </div>

                    </a>

                    @empty

                    <div class="chat-empty">
                        <p>Belum ada percakapan.</p>
                        <small>Chat tersedia setelah penugasan disetujui Admin.</small>
                    </div>

                    @endforelse

                </div>

            </section>


            <!-- ================= MY SCHEDULE CALENDAR ================= -->
            <section class="box calendar-card" id="bookings">

                <div class="calendar-top">

                    <h2>My Schedule</h2>

                    <div class="month-navigation">

                        <a href="{{ route('therapist.dashboard', ['month' => $previousMonth]) }}" aria-label="Bulan sebelumnya">
                            &lsaquo;
                        </a>

                        <span class="month-name">
                            {{ $currentMonth->translatedFormat('F Y') }}
                        </span>

                        <a href="{{ route('therapist.dashboard', ['month' => $nextMonth]) }}" aria-label="Bulan berikutnya">
                            &rsaquo;
                        </a>

                        <a href="{{ route('therapist.dashboard') }}" class="today-btn">
                            Hari Ini
                        </a>

                    </div>

                </div>


                <div class="calendar-grid">

                    <!-- WEEKDAYS -->
                    @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $weekday)

                    <div class="weekday">
                        {{ $weekday }}
                    </div>

                    @endforeach


                    <!-- CALENDAR DAYS -->
                    @foreach($calendarDays as $day)

                    @php
                    $dateKey = $day->format('Y-m-d');

                    $dayAssignments = $calendarAssignments->get($dateKey, collect());

                    $isCurrentMonth = $day->month === $currentMonth->month
                    && $day->year === $currentMonth->year;

                    $isToday = $day->isToday();
                    @endphp


                    <div class="calendar-day {{ $isCurrentMonth ? '' : 'other-month' }} {{ $dayAssignments->isEmpty() ? 'is-empty' : 'has-events' }} {{ $isToday ? 'is-today' : '' }}">

                        <div class="day-head">
                            <div class="day-number {{ $isToday ? 'today' : '' }}">
                                {{ $day->format('d') }}
                            </div>

                            <span class="day-name">
                                {{ $day->translatedFormat('l, d F') }}{{ $isToday ? ' · Hari ini' : '' }}
                            </span>
                        </div>


                        @forelse($dayAssignments as $assignment)

                        @php
                        $booking = $assignment->booking;

                        if ($assignment->status === 'completed') {
                        $eventClass = 'ev-completed';
                        } elseif ($assignment->status === 'accepted' && $assignment->admin_status === 'approved') {
                        $eventClass = 'ev-approved';
                        } elseif ($assignment->status === 'accepted' && $assignment->admin_status === 'rejected') {
                        $eventClass = 'ev-rejected';
                        } else {
                        $eventClass = 'ev-pending';
                        }
                        @endphp

                        <div class="booking-event {{ $eventClass }}">

                            <div class="event-time">
                                {{ substr($booking->booking_time, 0, 5) }}
                            </div>

                            <div class="event-treatment">
                                {{ $booking->treatment }}
                            </div>

                            <div class="event-customer">
                                {{ $booking->user->name ?? 'Customer' }}
                            </div>

                            @if($assignment->status === 'completed')

                            <span class="event-status completed">
                                Selesai
                            </span>

                            @elseif($assignment->status === 'accepted' && $assignment->admin_status === 'approved')

                            <span class="event-status approved">
                                Disetujui Admin
                            </span>

                            @elseif($assignment->status === 'accepted' && $assignment->admin_status === 'pending')

                            <span class="event-status pending">
                                Menunggu Persetujuan Admin
                            </span>

                            @elseif($assignment->status === 'accepted' && $assignment->admin_status === 'rejected')

                            <span class="event-status rejected">
                                Ditolak Admin
                            </span>

                            @endif


                            <!-- BOOKING DETAILS -->
                            <details class="booking-details">

                                <summary>Lihat Detail</summary>

                                <div class="details-content">

                                    <strong>Customer:</strong>
                                    {{ $booking->user->name ?? 'Customer' }}
                                    <br>

                                    <strong>Gender:</strong>
                                    {{ $booking->gender ?? '-' }}
                                    <br>

                                    <strong>Telepon:</strong>
                                    {{ $booking->phone ?? '-' }}
                                    <br>

                                    <strong>Treatment:</strong>
                                    {{ $booking->treatment }}
                                    <br>

                                    <strong>Tanggal:</strong>
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                                    <br>

                                    <strong>Waktu:</strong>
                                    {{ substr($booking->booking_time, 0, 5) }} WIB
                                    <br>

                                    <strong>Lokasi:</strong>
                                    {{ $booking->place === 'home' ? 'Home Service' : 'Klinik' }}
                                    <br>

                                    @if($booking->place === 'home')

                                    <strong>Alamat:</strong>
                                    {{ $booking->address ?? '-' }}
                                    <br>

                                    @endif

                                    <strong>Pembayaran:</strong>
                                    {{ $booking->payment_method ?? '-' }}
                                    <br>

                                    <strong>Harga Treatment:</strong>
                                    Rp{{ number_format($booking->price ?? 0, 0, ',', '.') }}
                                    <br>

                                    <strong>Biaya Layanan:</strong>
                                    Rp{{ number_format($booking->service_fee ?? 0, 0, ',', '.') }}
                                    <br>

                                    <strong>Total:</strong>
                                    Rp{{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                                    <br>

                                    <strong>Catatan:</strong>
                                    {{ $booking->notes ?: '-' }}

                                </div>

                            </details>


                            <!-- COMPLETE BOOKING -->
                            @if($assignment->status === 'accepted' && $assignment->admin_status === 'approved')

                            <form
                                action="{{ route('therapist.assignment.complete', $assignment->id) }}"
                                method="POST"
                                onsubmit="return confirm('Apakah treatment ini sudah selesai?')">

                                @csrf

                                <button type="submit" class="btn-complete">
                                    Tandai Selesai
                                </button>

                            </form>

                            @elseif($assignment->status === 'accepted' && $assignment->admin_status === 'pending')

                            <span class="event-status pending">
                                Menunggu Persetujuan Admin
                            </span>

                            @elseif($assignment->status === 'accepted' && $assignment->admin_status === 'rejected')

                            <span class="event-status rejected">
                                Ditolak Admin
                            </span>

                            @elseif($assignment->status === 'completed')

                            <span class="already-completed">
                                ✓ Treatment Selesai
                            </span>

                            @endif
                        </div>

                        @empty

                        <span class="empty-day">-</span>

                        @endforelse

                    </div>

                    @endforeach

                </div>

                @if($calendarAssignments->flatten(1)->isEmpty())
                <div class="calendar-empty-note">
                    Belum ada jadwal pada bulan ini.
                </div>
                @endif


                <!-- LEGEND -->
                <div class="calendar-legend">

                    <div class="legend-item">
                        <span class="legend-dot legend-approved"></span>
                        Diterima
                    </div>

                    <div class="legend-item">
                        <span class="legend-dot legend-completed"></span>
                        Selesai
                    </div>

                </div>

            </section>

        </main>


        <!-- ================= KOLOM KANAN ================= -->
        <aside class="right">

            <!-- NOTIFIKASI + PROFIL -->
            <div class="right-top">

                <a href="#incoming" class="bell {{ $pendingIncoming > 0 ? 'has-new' : '' }}" title="Pekerjaan masuk">
                    <svg class="ic" viewBox="0 0 24 24">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9M13.7 21a2 2 0 0 1-3.4 0" />
                    </svg>
                </a>

                <a href="{{ route('therapist.profile') }}" class="profile-link" title="Profil Saya">
                    {!! $avatar(Auth::user()) !!}
                    <span>{{ Auth::user()->name }}</span>
                </a>

            </div>


            <!-- KETERSEDIAAN -->
            <div>
                <div class="right-title">
                    <h3>Ketersediaan</h3>
                </div>

                <div class="panel">
                    <div class="availability-row">

                        @if(Auth::user()->is_available)
                        <span class="availability active">● Aktif</span>
                        @else
                        <span class="availability inactive">● Nonaktif</span>
                        @endif

                        <form action="{{ route('therapist.toggleAvailability') }}" method="POST">
                            @csrf

                            <button type="submit" class="availability-button">
                                {{ Auth::user()->is_available ? 'Jadikan Nonaktif' : 'Jadikan Aktif' }}
                            </button>
                        </form>

                    </div>
                </div>
            </div>


            <!-- STATISTICS -->
            @php
            $totalBase = max((int) $totalBooking, 1);
            @endphp

            <div>
                <div class="right-title">
                    <h3>Statistik Penugasan</h3>
                </div>

                <div class="panel">

                    <div class="stat-row">
                        <div class="stat-line"><span>Total Penugasan</span><b>{{ $totalBooking }}</b></div>
                        <div class="bar bar-total"><span style="width: 100%;"></span></div>
                    </div>

                    <div class="stat-row">
                        <div class="stat-line"><span>Menunggu Respons</span><b>{{ $pendingBooking }}</b></div>
                        <div class="bar bar-pending"><span style="width: {{ round($pendingBooking / $totalBase * 100) }}%;"></span></div>
                    </div>

                    <div class="stat-row">
                        <div class="stat-line"><span>Diterima</span><b>{{ $approvedBooking }}</b></div>
                        <div class="bar bar-approved"><span style="width: {{ round($approvedBooking / $totalBase * 100) }}%;"></span></div>
                    </div>

                    <div class="stat-row">
                        <div class="stat-line"><span>Selesai</span><b>{{ $completedBooking }}</b></div>
                        <div class="bar bar-done"><span style="width: {{ round($completedBooking / $totalBase * 100) }}%;"></span></div>
                    </div>

                </div>
            </div>


            <!-- JADWAL HARI INI -->
            <div>
                <div class="right-title">
                    <h3>Jadwal Hari Ini</h3>
                    <a href="#bookings">Lihat semua</a>
                </div>

                <div class="panel">

                    @forelse($todayAssignments->sortBy(fn($item) => $item->booking->booking_time) as $assignment)

                    @php
                    $booking = $assignment->booking;
                    @endphp

                    <div class="today-item">

                        <div class="today-person">
                            {!! $avatar($booking->user, $palette[$booking->id % 4]) !!}

                            <div>
                                <b>{{ $booking->user->name ?? 'Customer' }}</b>
                                <small>{{ $booking->treatment }} · {{ $booking->place === 'home' ? 'Home Service' : 'Klinik' }}</small>
                            </div>
                        </div>

                        <div class="today-meta">
                            <span>
                                <svg class="ic" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <path d="M16 2v4M8 2v4M3 10h18" />
                                </svg>
                                {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                            </span>

                            <span>
                                <svg class="ic" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v5l3 2" />
                                </svg>
                                {{ substr($booking->booking_time, 0, 5) }}
                            </span>
                        </div>

                        <div class="today-status">
                            @if($assignment->status === 'completed')
                            <span class="assignment-status" style="background: var(--done-bg); color: var(--done);">Selesai</span>
                            @elseif($assignment->status === 'accepted' && $assignment->admin_status === 'approved')
                            <span class="assignment-status" style="background: var(--ok-bg); color: var(--ok);">Disetujui Admin</span>
                            @elseif($assignment->status === 'accepted' && $assignment->admin_status === 'pending')
                            <span class="assignment-status pending">Menunggu Persetujuan Admin</span>
                            @elseif($assignment->status === 'accepted' && $assignment->admin_status === 'rejected')
                            <span class="assignment-status rejected">Ditolak Admin</span>
                            @endif
                        </div>

                    </div>

                    @empty

                    <div class="today-empty">
                        Tidak ada jadwal hari ini.
                    </div>

                    @endforelse

                    <a href="#bookings" class="btn-wide">Buka Kalender</a>

                </div>
            </div>


            <!-- NOTIFIKASI TERBARU -->
            <div>
                <div class="right-title">
                    <h3>Notifikasi Terbaru</h3>
                </div>

                @if($pendingIncoming > 0)

                <a href="#incoming" class="notif">
                    <div>
                        <b>{{ $pendingIncoming }} pekerjaan menunggu respons</b>
                        <small>Terima atau tolak di bagian Pekerjaan Masuk</small>
                    </div>
                    <svg class="ic" viewBox="0 0 24 24">
                        <path d="M5 12h14M13 5l7 7-7 7" />
                    </svg>
                </a>

                @else

                <div class="notif plain">
                    <div>
                        <b>Tidak ada notifikasi baru</b>
                        <small>Semua pekerjaan sudah direspons</small>
                    </div>
                </div>

                @endif
            </div>

        </aside>

    </div>


    <script>
        // ================= PENCARIAN =================

        const searchInput = document.getElementById('searchInput');
        const searchNote = document.getElementById('searchNote');
        const searchWord = document.getElementById('searchWord');

        searchInput.addEventListener('input', function() {
            const keyword = searchInput.value.trim().toLowerCase();
            let visible = 0;

            document.querySelectorAll('.incoming-card, .booking-event, .chat-item').forEach(function(item) {
                const cocok = item.textContent.toLowerCase().includes(keyword);
                item.style.display = cocok ? '' : 'none';

                if (cocok) visible++;
            });

            searchWord.textContent = searchInput.value.trim();
            searchNote.hidden = !keyword || visible > 0;
        });

        // Tekan "/" untuk langsung mengetik di kotak pencarian
        document.addEventListener('keydown', function(event) {
            const tag = (event.target.tagName || '').toLowerCase();

            if (event.key === '/' && tag !== 'input' && tag !== 'textarea') {
                event.preventDefault();
                searchInput.focus();
            }

            if (event.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.blur();
            }
        });


        // ================= TANGGAL & JAM =================

        const clock = document.getElementById('clock');

        function updateClock() {
            const now = new Date();

            const tanggal = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            const jam = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            }).replace('.', ':');

            clock.textContent = tanggal + ' · ' + jam;
        }

        updateClock();
        setInterval(updateClock, 30000);


        // ================= NOTIFIKASI: TUTUP / HILANG OTOMATIS =================

        document.querySelectorAll('.alert').forEach(function(alertBox) {
            const close = document.createElement('button');

            close.type = 'button';
            close.className = 'alert-close';
            close.setAttribute('aria-label', 'Tutup');
            close.innerHTML = '&times;';

            close.addEventListener('click', function() {
                alertBox.remove();
            });

            alertBox.appendChild(close);

            if (alertBox.classList.contains('success')) {
                setTimeout(function() {
                    alertBox.style.opacity = '0';
                    setTimeout(function() {
                        alertBox.remove();
                    }, 400);
                }, 6000);
            }
        });


        // ================= CEGAH KLIK GANDA SAAT KIRIM FORM =================

        document.addEventListener('submit', function(event) {
            if (event.defaultPrevented) return; // dibatalkan lewat confirm()

            const buttons = event.target.querySelectorAll('button[type="submit"]');

            setTimeout(function() {
                buttons.forEach(function(btn) {
                    btn.classList.add('is-loading');
                });
            }, 0);
        });


        // ================= MENU SAMPING: MENYALA SESUAI BAGIAN =================

        const spyLinks = Array.from(document.querySelectorAll('.side-nav a[data-spy]'));

        function spyScroll() {
            let current = spyLinks.find(function(a) {
                return a.dataset.spy === 'top';
            });

            const batas = window.innerHeight * 0.4;

            spyLinks.forEach(function(a) {
                if (a.dataset.spy === 'top') return;

                const target = document.querySelector(a.dataset.spy);

                if (target && target.getBoundingClientRect().top <= batas) {
                    current = a;
                }
            });

            spyLinks.forEach(function(a) {
                a.classList.toggle('active', a === current);
            });
        }

        window.addEventListener('scroll', spyScroll, {
            passive: true
        });
        spyScroll();


        // ================= PEKERJAAN MASUK: GESER KE SAMPING =================

        const incomingTrack = document.getElementById('incomingTrack');

        if (incomingTrack) {
            const geser = function(arah) {
                const kartu = incomingTrack.querySelector('.incoming-card');
                const lebar = kartu ? kartu.offsetWidth + 14 : 300;

                incomingTrack.scrollBy({
                    left: arah * lebar,
                    behavior: 'smooth'
                });
            };

            const btnPrev = document.getElementById('incomingPrev');
            const btnNext = document.getElementById('incomingNext');

            if (btnPrev) btnPrev.addEventListener('click', function() {
                geser(-1);
            });

            if (btnNext) btnNext.addEventListener('click', function() {
                geser(1);
            });
        }


        // ================= PEKERJAAN TERDEKAT: KARTU BERTUMPUK =================

        const stackCards = Array.from(document.querySelectorAll('.stack-card'));
        const stackCounter = document.getElementById('stackCounter');

        let activeCard = 0;

        function renderStack() {
            const total = stackCards.length;

            stackCards.forEach(function(card, i) {
                card.dataset.pos = (i - activeCard + total) % total;
            });

            if (stackCounter) {
                stackCounter.textContent = (activeCard + 1) + ' / ' + total;
            }
        }

        if (stackCards.length > 1) {
            document.getElementById('stackNext').addEventListener('click', function() {
                activeCard = (activeCard + 1) % stackCards.length;
                renderStack();
            });

            document.getElementById('stackPrev').addEventListener('click', function() {
                activeCard = (activeCard - 1 + stackCards.length) % stackCards.length;
                renderStack();
            });
        }
    </script>

</body>

</html>