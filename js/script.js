// JavaScript Document

$(document).ready(function() {
    
    $('.page').ajaxStart(function() {
        $('.mask').show();        
    });
    
    $(".page").ajaxStop(function() {
//        setTimeout(function() {
//            $('.mask').hide();
//        },3000);        
          $('.mask').hide();
    });    

    //, .ajaxStop(), .ajaxComplete(), .ajaxError(), .ajaxSuccess(), .ajaxSend()
    
    function setCatalog(filters, page) {
        $.ajax({
            type: "POST",
            url: "ajax/filters.php",
            dataType: 'json',
            data: {"filters": filters, "page": page},
            success: function(response) {
                // console.log(response);
                $('.catalog').html(response.content);
                $('.paginator').replaceWith(response.paginator);
            }
        });
    }

    function getContentByHash() {
        var startfilters = document.location.hash.replace('#', '');
        startfilters = startfilters.split('/');
        var page = 1;
        var filters = [];
        for(var key in startfilters) {

            if(startfilters[key]) {
                var filterData = startfilters[key].split('_');
                if (filterData.length > 1) {
                    var filterParams = filterData[1].split('-');
                    for (var i in filterParams) {
                        if(filterParams[i]) {
                            var tmp = {};
                            tmp[filterData[0]] = filterParams[i];
                            filters.push(tmp);
                        }
                    }
                } else {
                    if(startfilters[key].indexOf('q=') == -1) {
                        page = startfilters[key].replace('p', '');
                    } else {
                        var query = {};
                        query['query'] = startfilters[key].replace('q=', '');
                    }                    
                }
            }
        }

        if(filters.length > 0) {
            $('.changed').show();
            for(var i in filters) {
                for(var key in filters[i]) {
                    //console.log($('.changed .' + key).parent().html());
                    $('.changed .' + key).parent().show();

                    $('.changed .' + key).parent().find('a').each(function(index, el) {
                        if ($(el).attr('rel') == filters[i][key]) {
                            $(el).parent().show();
                        }
                    });

                    $('.forChange .' + key).parent().find('a').each(function(index, el) {
                        if ($(el).attr('rel') == filters[i][key]) {
                            $(el).parent().hide();
                        }
                    });

                }
            }
        }

        if(query) {
            filters = [];
            filters[0] = query;
        }

        if (filters.length > 0 || page > 1) {
            setCatalog(filters, page);
        }
    }
    
    function hideTitle(tmpThis) {
        var i = 0;
        $(tmpThis).parent().parent().find('p:visible').each(function(index, el) {
	    i++;
	});
        if (i==1) {
            $(tmpThis).parent().parent().hide();
        }
    }



    function getDataFromFilter(page) {

        var filters = [];
        var filter = '';

        if(document.location.hash.indexOf('q=') == -1 || !page) {

            function getFilter(name, val) {

                var reg = new RegExp(name + '\\w*', 'g');
                if(reg.test(filter)) {
                    filter += '-' + val ;
                } else {
                    filter += name + '_' + val ;
                }
            }


            $('.changed').find('h4').parent().each(function(index, el) {
                var parentThis = this;
                var flag = false;
                $(this).find('a:visible').each(function(index, el) {
                    flag = true;
                    var tmp = {};
                    if ($(this).attr('rel')) {
                        tmp[$(parentThis).find('h4').attr('class')] = $(this).attr('rel');
                        getFilter($(this).parent().parent().find('h4').attr('class'), $(this).attr('rel'));
                    } else {
                        tmp[$(parentThis).find('h4').attr('class')] = $(this).text();
                        getFilter($(this).parent().parent().find('h4').attr('class'), $(this).text());
                    }

                    filters.push(tmp);
                });
                if (flag) filter += '/';
            });

            if (!page) {
                page = 1;
            }
            
        } else {

            var startfilters = document.location.hash.replace('#', '');
            startfilters = startfilters.split('/');

            for(var key in startfilters) {

                if(startfilters[key]) {
                    if(startfilters[key].indexOf('q=') >= 0) {
                        var query = {};
                        query['query'] = startfilters[key].replace('q=', '');
                    }
                }
            }
            filter = 'q=' + query['query'];
            filters[0] = query;
        }

        document.location.hash = '#p'+ page + '/' + filter;

        setCatalog(filters, page);
        
    }

    

  

    $('.forChange').find('a').live('click', function() {

		/*
		var nameCategory = $(this).parent().parent().find('h4').attr('class');

        $('.changed').show();
		
		if (!$('.changed').find('.' + nameCategory).is('h4')) {
            $('.changed').append('<div></div>');
			$('.changed div:last').append($('.' + nameCategory).clone());
		}
		
		
		$('.changed').find('.' + nameCategory).parent().append($(this).parent().clone());
		$(this).parent().hide();
        */


        $(this).parent().hide();

            var tmpThis = this;

        $('.changed').find('a').each(function(index, el) {
            if ($(el).text() == $(tmpThis).text()) {
                $(el).parent().parent().show();
                $(el).parent().show();
                $('.changed').show();
            }
        });

        hideTitle(this);

        getDataFromFilter();

        return false;

    });

    

    $('.changed').find('a').live('click', function() {

        $(this).parent().hide();
		
        var tmpThis = this;

        $('.forChange').find('a').each(function(index, el) {
            if ($(el).text() == $(tmpThis).text()) {
                $(el).parent().parent().show();
                $(el).parent().show();
            }
        });

        hideTitle(this);
        
        var i = 0;
        
        $('.changed').find('div:visible').each(function(index, el) {
            i++;
        });
        if (i==1) {
            $('.changed').hide();
        }

        getDataFromFilter();

        return false;

    });


    $('.paginator').find('a').live('click', function() {
        
        if ($(this).attr('value') * 1 > 0) {
            getDataFromFilter($(this).attr('value'));
        }

        return false;
    });


    $('.next').live('click', function() {
        var page = $('.paginator span').html();
        var nextPage = false;
        $('.paginator').find('a').each(function(index, el) {
            if ($(el).text() * 1){
                if (page * 1 < $(el).text() * 1) {
                    nextPage = true;
                }
            }
        });
        if (nextPage) {
            getDataFromFilter(page * 1 + 1);
        }
    });


    $('.prev').live('click', function() {
        var page = $('.paginator span').html();
        var nextPage = false;
        $('.paginator').find('a').each(function(index, el) {
            if ($(el).text() * 1) {
                if (page * 1 > $(el).text() * 1) {
                    nextPage = true;
                }
            }
        });
        if (nextPage) {
            getDataFromFilter(page * 1 - 1);
        }
    });

    $(".addComment").click(function(){
        $(".addCommentForm").slideToggle();
        return false;
    });

    
    $("#commentForm").validate({
  	submitHandler: function(form) {
            $(form).ajaxSubmit({
                success: function(response) {
                    if(response != 'error') {
                        $(".addCommentForm").hide();
                        $(".addComment").hide();
                        $('#comments .comment').html(response);
                    } else {
                        alert('Комментарий не добавлен! Попробуйте попозже. Скорее всего вы попытались добавить подряд 2 комментария к одной модели в течении 10 минут.');
                    }
                }
            });
        }
    });
    
    function getSearch() {
        document.location.hash = '#p1/q=' + $('.searchString').val();
        var filters = [];
        var obj = {};
        obj['query'] = $('.searchString').val();
        filters[0] = obj;
        setCatalog(filters, 1);
    }

    $(".searchButton").click(function() {
        getSearch();
    });

    $('.searchString').keypress(function(el) {
        if (el.keyCode == 13) {
            getSearch();
        }
    });

    getContentByHash();
    
    
});
