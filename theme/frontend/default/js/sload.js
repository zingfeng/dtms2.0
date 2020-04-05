var sload = {
    domain: [], // list
    load: function (domain) {
        // Cập nhật danh sách domain
        sload.domain = domain;

        $(".sload").error(function () {
            var list_domain = sload.domain;
            try {
                // List tried
                var attr = $(this).attr('sload-tried');
                if (typeof attr !== typeof undefined && attr !== false) {
                    $(this).attr('sload-tried','');
                }
                var tried =  $(this).attr('sload-tried');

                var src = $(this).attr("src");
                var arr = src.split("/");
                var fail_domain = arr[0] + "//" + arr[2];

                var uri = src.replace('fail_domain','');

                var list_fail_domain = tried + ' ' + fail_domain;
                $(this).attr('sload-tried', list_fail_domain);

                var tried_all = true;
                for (var i = 0; i < list_domain.length; i++) {
                    var domain = list_domain[i];
                    if (! list_fail_domain.includes(domain)){
                        $(this).attr("src", domain + uri);
                        tried_all = false;
                        break;
                    }
                }

                if (tried_all){
                    $(this).removeClass('sload');
                    $(this).addClass('sload-finish');
                }


            } catch (err) {
                console.log(err.message);
            }

        });
    },
};
