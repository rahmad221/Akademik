<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup Form</title>
    {{-- Arahkan ke file CSS Anda --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .error-message { color: #dc3545; font-size: 14px; margin-top: 5px; display: block; }
        .btn-submit.loading { background-color: #6c757d; cursor: not-allowed; }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="tab-header">
            <button class="tab-link active" onclick="switchForm('login')">Login</button>
            <button class="tab-link" onclick="switchForm('signup')">Signup</button>
        </div>

        <div class="form-body">
            <div id="login" class="form-content active">
                <form id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-wrapper">
                        <input type="email" name="email" placeholder="Email Address" required>
                        <span class="error-message" data-field="email"></span>
                    </div>
                    <div class="input-wrapper">
                        <input type="password" name="password" placeholder="Password" required>
                        <span class="error-message" data-field="password"></span>
                    </div>
                    <button type="submit" class="btn-submit">Login</button>
                </form>
            </div>

            <div id="signup" class="form-content">
                <form id="register-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-wrapper">
                        <input type="text" name="name" placeholder="Full Name" required>
                        <span class="error-message" data-field="name"></span>
                    </div>
                    <div class="input-wrapper">
                        <input type="email" name="email" placeholder="Email Address" required>
                        <span class="error-message" data-field="email"></span>
                    </div>
                    <div class="input-wrapper">
                        <input type="password" name="password" placeholder="Password" required>
                        <span class="error-message" data-field="password"></span>
                    </div>
                     <div class="input-wrapper">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                    <button type="submit" class="btn-submit">Signup</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fungsi untuk switch tab (tetap sama)
        function switchForm(formId) {
            $('.form-content').removeClass('active');
            $('.tab-link').removeClass('active');
            $('#' + formId).addClass('active');
            event.currentTarget.classList.add('active');
        }

        // Script AJAX
        $(document).ready(function() {
            // Ketika form di-submit
            $('#login-form, #register-form').on('submit', function(event) {
                event.preventDefault(); // Mencegah refresh halaman

                var form = $(this);
                var button = form.find('.btn-submit');
                var url = form.attr('action');
                var data = form.serialize();

                // Bersihkan error sebelumnya dan nonaktifkan tombol
                form.find('.error-message').text('');
                button.addClass('loading').prop('disabled', true);

                // Kirim request AJAX
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function(response) {
                        // Jika sukses, redirect ke halaman yang diberikan controller
                        window.location.href = response.redirect;
                    },
                    error: function(xhr) {
                        // Jika gagal, tampilkan pesan error
                        button.removeClass('loading').prop('disabled', false);
                        
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                // Tampilkan error di bawah input yang sesuai
                                form.find('.error-message[data-field="' + key + '"]').text(value[0]);
                            });
                        } else {
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    }
                });
            });
        });
    </script>

</body>
</html>