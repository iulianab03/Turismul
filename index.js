(
    function() {
    // deschiderea meniului de navigare la click-ul utilizatorului pe butonul specializat
    document.getElementById('menu-slider-open').addEventListener('click', function() {
        document.getElementById('sidebar-container').style.display = 'block';
        setTimeout(function() {
            document.getElementById('sidebar').style.right = '0';
        }, 50);
    });
   //închiderea meniului de navigare la click-ul utilizatorului pe butonul specializat
    document.getElementById('close-sidebar').addEventListener('click', function() {
        document.getElementById('sidebar').style.right = '-200px';

        setTimeout(function() {
            document.getElementById('sidebar-container').style.display = 'none';
        }, 500);
    });
    //deschiderea sub meniului în meniul de navigare la click-ul utilizatorului pe butonul specializat
    document.querySelectorAll('.sidebar-arrow').forEach(function(item) {
        item.addEventListener('click', function(){
            var parent = this.parentElement;
            
            if (parent.getAttribute('active') != null && parent.getAttribute('active') != '') {
                parent.removeAttribute('active');
                parent.classList.remove('active');
                parent.parentNode.querySelector('.sublist').classList.remove("show");
                
            }
            else {
                ResetSidebarItems(); 
                parent.classList.add('active');
                parent.setAttribute('active', 'true');
                parent.parentNode.querySelector('.sublist').classList.add("show");
            }
        });
    });
})();

// resetarea claselor pentru elementele barei de navigare !
function ResetSidebarItems () {
    var classOpen = document.querySelectorAll('.navbar-main-link-container.active')[0];

    if (classOpen != undefined) {
        classOpen.classList.remove('active');
        classOpen.setAttribute('active', '');
        classOpen.parentNode.querySelector('.sublist').classList.remove("show");
    }
}

// verificarea datelor pentru forma de logare
$(document).on('submit', '#login-site', function (e) {
    e.preventDefault();
    var email = $(this).find('input[name=email]');
    var parola = $(this).find('input[name=parola]');
    parola.removeClass('error');
    email.removeClass('error');
    $('.overlay-error').text('');

    if (email.val().length == 0) {
        email.addClass('error');
        email.attr('placeholder', 'Email-ul este obligatoriu');
        e.preventDefault();
        return;
    }
    
    if (parola.val().length == 0) {
        parola.addClass('error');
        parola.attr('placeholder', 'Parola este obligatoriu');
        e.preventDefault();
        return;
    }

// chemarea formei de logare. In caz ca logarea nu a reusit afisez mesajul de eroare
    $.ajax({ //cerere asincrona
        url:"index.php", 
        type:"POST", 
        data:{action:"login", "email":email.val(), "parola":parola.val()}
    }).then(function(data) {
        if (data.length > 0) {
            $('.overlay-error').text(data);
        }
        else {
            window.location.href = "index.php";
        }
    });
});

// afisarea formei in caz ca utilizatorul nu e logat
$(document).on('click', "a", function(e) {
    e.preventDefault();
    var link = $(this).attr("href");

    $.ajax({"url": "index.php", "type": "GET", data:{"action": "check"}}).then(function(data) {
        if (data == '1') {
            window.location.href = link;
        }
        else {
            $('#overlay-container').show();
        }
    });
});

// afisarea pop up-ului de logare in caz ca utilizatorul nu e logat
$(document).on('click', '#loginButton', function () {
    $('#overlay-container').show();
});

// validarea formei de trimitere a mesajului in pagina contacte
$(document).on('submit', '#app-form-container', function(e) {
    e.preventDefault();
    var form = $(this);
    form.find('app-form-error').css('display', 'none');

    var name = form.find('.app-form-input[name=name]').val();
    var email = form.find('.app-form-input[name=email]').val();
    var subject = form.find('.app-form-input[name=subject]').val();
    var message = form.find('.app-form-input[name=message]').val();

    if (name.length == 0 || email.length == 0 || message.length == 0) {
        $('#app-form-error').css('display', 'inline-block');
        return;
    }
    else {
        var url = form.attr('action');
        $.ajax({ // cheamă controler-ul de tip post 
            "url": url, 
            "type":"POST", 
            data:{"action":"sendMail", "name": name, "email": email, "subject": subject, "message": message}
        }).then(function(data){ // in caz de primirea inapoi a datelor, se afiseaza mesajul corespunzator
            $("#app-form-body").css('display', 'none');
            $("#app-form-result").css('display', 'inline-block');
        });
    }
});

// logout pentru utilizator
$(document).on('click', '#logoutLink', function () {
    $.ajax({"url":"index.php", "type": "POST", data:{"action":"logout"}}).then(function () {
        window.location.href = "index.php";
    });
});
