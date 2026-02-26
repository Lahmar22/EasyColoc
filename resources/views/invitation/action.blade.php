<!DOCTYPE html>
<html>
<head>
    <title>Invitation</title>
</head>
<body>

    <h2>You are invited to join EasyColoc 🎉</h2>

    <form method="POST" action="/accept-invitation">
        @csrf
        <input type="hidden" name="token" value="{{ $invitation->token }}">
        <button type="submit">✅ Accept</button>
    </form>

    <br>

    <form method="POST" action="/refuse-invitation">
        @csrf
        <input type="hidden" name="token" value="{{ $invitation->token }}">
        <button type="submit">❌ Refuse</button>
    </form>

</body>
</html>