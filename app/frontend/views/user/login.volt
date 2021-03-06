<h3>Вход в личный кабинет</h3   >
<div class="content-form-page">
    {% if errors|length > 0 %}
        <div class="note note-danger">
            <p>
                {% for error in errors %}
                    {{ error }}.<br>
                {% endfor %}
            </p>
        </div>
    {% endif %}
    <div class="row">
        <div class="col-md-7 col-sm-7">
            <form class="form-horizontal form-without-legend" role="form" action="" method="POST">
                <div class="form-group">
                    <label for="email" class="col-lg-4 control-label">Email <span class="require">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" id="email" value="{{ email }}" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-lg-4 control-label">Пароль <span class="require">*</span></label>
                    <div class="col-lg-8">
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-offset-4 padding-left-0">
                        <a href="forgotton-password.html">Забыли пароль?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>