<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Guavira</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h1>Register a Guavira Tree</h1>

    <form method="POST" action="{{ route('guavira.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="descricao">Description:</label>
            <textarea id="descricao" name="descricao" rows="4" cols="50" required></textarea>
        </div>

        <div class="location-options">
            <label for="location-type">Location Type:</label>
            <div class="location-buttons">
                <input type="radio" id="manual-coordinates" name="location_type" value="manual" required>
                <label for="manual-coordinates">Manual Coordinates</label>
                <input type="radio" id="endereco" name="location_type" value="endereco" required>
                <label for="endereco">Address</label>
            </div>
        </div>

        <div id="manual-coordinates-fields" style="display: none;">
            <div class="form-group">
                <label for="latitude">Latitude:</label>
                <input type="number" step="any" id="latitude" name="latitude" min="-90" max="90">
            </div>
            <div class="form-group">
                <label for="longitude">Longitude:</label>
                <input type="number" step="any" id="longitude" name="longitude" min="-180" max="180">
            </div>
        </div>

        <div id="endereco-field" style="display: none;">
            <div class="form-group">
                <label for="endereco">Address:</label>
                <input type="text" id="endereco" name="endereco">
            </div>
        </div>

        <div class.form-group>
            <label for="imagem">Image (Optional):</label>
            <input type="file" id="imagem" name="imagem">
        </div>

        <button type="submit">Register Guavira</button>
    </form>

    <script>
        $(document).ready(function() {
            let locationType = $('input[name="location_type"]:checked').val();
            toggleLocationFields(locationType);

            $('input[name="location_type"]').change(function() {
                let locationType = $(this).val();
                toggleLocationFields(locationType);
            });
        });

        function toggleLocationFields(locationType) {
            if (locationType === 'manual') {
                $('#manual-coordinates-fields').show();
                $('#endereco-field').hide();
            } else if (locationType === 'endereco') {
                $('#manual-coordinates-fields').hide();
                $('#endereco-field').show();
            }
        }
    </script>
</body>
</html>