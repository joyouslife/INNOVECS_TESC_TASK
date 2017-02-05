
var General = {
    init: function ()
    {
        this.login.init();
        this.events.init();
        this.users.init();
    },

    events: {
        mainSelector: '#events-report',

        init: function ()
        {
            var self = General.events;

            self.initDatepicker();
            self.initTableLayout();
        },

        initDatepicker: function ()
        {
            var self = General.events;

            $(self.mainSelector + ' input#date').datepicker({
                autoclose: true
            });
        },

        initTableLayout: function ()
        {
            var self = General.events;

            $(self.mainSelector + ' #report-table').DataTable();
        },
    },

    login:
    {
        form: '#sign-in-form',

        init: function ()
        {
            var self = General.login;

            $(self.form).on('submit', self.onSubmitLoginForm);
        },

        onSubmitLoginForm: function ()
        {
            var self = General.login;
            $(self.form + ' #message').attr('class', 'alert');
            $(self.form + ' #message').html('');
            $(self.form + ' .error-message').html('');

            checked = self.checkForm();

            if (!checked) {
                return false;
            }

            var data = {
                login: self.getLogin(),
                password: self.getPassword()
            }


            $.post('/login/ajax', data, self.onAjaxResponse);

            return false;
        },

        onAjaxResponse: function (response)
        {
            var self = General.login;

            if (response.status == 'error') {
                $(self.form + ' #message').addClass('alert-danger');
            } else {
                $(self.form + ' #message').addClass('alert-success');

                setTimeout(function () {
                    location.reload();
                }, 1000);
            }

            $(self.form + ' #message').html(response.message);
        }, // end onAjaxResponse

        checkForm : function ()
        {
            var self = General.login;

            login = self.getLogin();
            password = self.getPassword();

            var hasErrors = false;

            if (!login) {
                $(self.form + ' .message-login').html('Required field');
                hasErrors = true;
            }

            if (!password) {
                $(self.form + ' .message-password').html('Required field');
                hasErrors = true;
            }

            return hasErrors == false;
        },

        getLogin : function ()
        {
            var self = General.login;

            return $(self.form + ' #login').val();
        },

        getPassword : function ()
        {
            var self = General.login;

            return $(self.form + ' #password').val();
        },
    },

    users: {
        init: function ()
        {
            var self = General.users;

            self.add_new_form.init();
            self.delete.init();
            self.edit.init();
        },

        add_new_form: {
            form: '#add-user-form',

            init: function ()
            {
                var self = General.users.add_new_form;

                $(self.form).on('submit', self.onSubmitForm);
            },

            onSubmitForm: function ()
            {
                var self = General.users.add_new_form;

                $(self.form + ' #message').attr('class', 'alert');
                $(self.form + ' #message').html('');
                $(self.form + ' .error-message').html('');

                checked = self.checkForm();

                if (!checked) {
                    return false;
                }

                var data = {
                    login: self.getLogin(),
                    role: self.getRole()
                }


                $.post('/users/add-new-ajax', data, self.onAjaxResponse);

                return false;
            },

            checkForm: function ()
            {
                var self = General.users.add_new_form;

                login = self.getLogin();
                role = self.getRole();

                var hasErrors = false;

                if (!login) {
                    $(self.form + ' .message-login').html('Required field');
                    hasErrors = true;
                }

                if (!role) {
                    $(self.form + ' .message-role').html('Required field');
                    hasErrors = true;
                }

                return hasErrors == false;
            },

            getLogin: function ()
            {
                var self = General.users.add_new_form;

                return $(self.form + ' #login').val();
            },

            getRole: function ()
            {
                var self = General.users.add_new_form;

                return $(self.form + ' #role').val();
            },

            onAjaxResponse: function (response)
            {
                console.log(response);
                var self = General.users.add_new_form;

                if (response.status == 'error') {
                    $(self.form + ' #message').addClass('alert-danger');
                } else {
                    $(self.form + ' #message').addClass('alert-success');
                }

                $(self.form + ' #message').html(response.message);
            }, // end onAjaxResponse
        },

        delete: {
            mainSelector: '#users',

            init: function ()
            {
                var self = General.users.delete;

                $(self.mainSelector + " .delete").on('click', self.onDelete);
            },

            onDelete: function ()
            {
                var self = General.users.delete;

                if (!confirm("Are you sure?")) {
                   return false;
                }

                var userID = $(this).attr('data-user-id');

                var data = {
                    user_id: userID
                }

                $.post('/users/delete-ajax', data, self.onAjaxResponse);

                return false;
            },

            onAjaxResponse: function (response)
            {
                var self = General.users.delete;

                console.log(response);

                if (response.status == 'error') {
                    alert(response.message);
                } else {
                    selector = $(self.mainSelector + ' [data-user-id="' + response.remove_item + '"]');
                    parent = $(selector).parents('tr');
                    $(parent).remove();
                    self.refreshRowsCount();
                }
            },

            refreshRowsCount: function ()
            {
                var self = General.users.delete;

                $(self.mainSelector + ' table tbody th').each(function(key, value){
                    $(this).html(key + 1);
                })
            }, // end refreshRowsCount
        },

        edit: {
            form: '#edit-user-form',

            init: function ()
            {
                var self = General.users.edit;

                $(self.form).on('submit', self.onSubmitForm);
            },

            onSubmitForm: function ()
            {
                var self = General.users.edit;

                $(self.form + ' #message').attr('class', 'alert');
                $(self.form + ' #message').html('');
                $(self.form + ' .error-message').html('');

                checked = self.checkForm();

                if (!checked) {
                    return false;
                }

                var data = {
                    user_id: self.getID(),
                    login: self.getLogin(),
                    role: self.getRole(),
                    password: self.getPassword()
                }

                $.post('/users/edit-ajax', data, self.onAjaxResponse);

                return false;
            },

            checkForm: function ()
            {
                var self = General.users.edit;

                login = self.getLogin();
                role = self.getRole();
                password = self.getPassword();
                repassword = self.getRePassword();
                minPassLength = 6;

                var hasErrors = false;

                if (!login) {
                    $(self.form + ' .message-login').html('Required field');
                    hasErrors = true;
                }

                if (password) {
                    if (password.length < minPassLength) {
                        $(self.form + ' .message-password').html('Password is short');
                        hasErrors = true;
                    }
                } else if(!password && repassword) {
                    $(self.form + ' .message-password').html('Required field');
                    hasErrors = true;
                }

                if (repassword && (password != repassword)) {
                    $(self.form + ' .message-repassword').html('Passwords do not match');
                    hasErrors = true;
                } else if (password && !repassword) {
                    $(self.form + ' .message-repassword').html('Confirm password');
                    hasErrors = true;
                }

                return hasErrors == false;
            },

            getID: function ()
            {
                var self = General.users.edit;

                return $(self.form + ' #user_id').val();
            },

            getLogin: function ()
            {
                var self = General.users.edit;

                return $(self.form + ' #login').val();
            },

            getRole: function ()
            {
                var self = General.users.edit;

                return $(self.form + ' #role').val();
            },

            getPassword: function ()
            {
                var self = General.users.edit;

                return $(self.form + ' #password').val();
            },

            getRePassword: function ()
            {
                var self = General.users.edit;

                return $(self.form + ' #repassword').val();
            },

            onAjaxResponse: function (response)
            {
                console.log(response);
                var self = General.users.edit;

                if (response.status == 'error') {
                    $(self.form + ' #message').addClass('alert-danger');
                } else {
                    $(self.form + ' #message').addClass('alert-success');
                }

                $(self.form + ' #message').html(response.message);
            }, // end onAjaxResponse

        }
    }

}

$(document).ready(function () {
    General.init();
})
