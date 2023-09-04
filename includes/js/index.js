//zatvaranje prozora
 $(document).on('click', '.close-modal', function() {
	 $('.backdrop').css("display", "none").empty();
 });



// dogadjaji iz glavnog menija
	 // a tag link
	 $('#naviglinks_body .menu').click(function() {
		 $('#loadresource').empty();
		 $('.menu').removeClass('selected');
		var res = '#'+$(this).attr('data-res');
		var res1 = 'li[data-res='+$(this).attr('data-res')+']';
		$(res1).addClass('selected');
		if ($('#loadresource').is(':empty')){
			var title = $(this).text();
			window.class1 = $(this).attr('data-class');
			window.title= title;
			window.resdes=$(this).attr('data-resdes')
			//loader
			var ll = $('#rw').text()+'admin/loader.php';
			$('#loadresource').load(ll);
			// priprema za izvrsenje stavke glavnog menija
			window.folder = $('#rw').text()+'admin/'+$(this).attr('data-folder');
			var param = $(this).attr('data-param');
			window.param = param;
			var link = window.folder+"/index.php";
			table(link,param); //izvrsenje stavke, ucitavanje tabele iz index.php
		}
	 });


//hide_rows();


// funkcije
	// desno glavno
	// izvresnje tabele u index.php
		function table(link,param) {
		    $.ajax({
                type: 'POST',
                url: link,
                data: param+'&frontadmin=1',
                    success: function(data) {
                        $('#loadresource').html(data);
                        prepare();
                    }
            });

		}

	// skrivanje polja u frontadministraciji
		function hide_rows() {
			var hf='';
			$('#hf_cont .hf').each(function() {
				var name=$(this).text();
				hf=hf+name+',';
			})
			//var hf='author,publisher,';
			$('#inner select, #inner input, #inner textarea').each(function() {
				var name=$(this).attr('name');
				if (hf.indexOf(name)>=0 && $(this).attr('type') !== 'hidden') $(this).parent().parent().hide();
			})
		};
		function show_star() {
			var vf=[];
			$('#vf_cont .vf').each(function() {
				var name=$(this).text();
				vf.push(name);
			})
			$('#inner select, #inner input, #inner textarea').each(function() {
				var name=$(this).attr('name');
				if (jQuery.inArray(name,vf) !== -1 && $(this).attr('type') !== 'hidden') {
					var x = $(this).parent().parent().find('label').html();
					x = x + ' *';
					$(this).parent().parent().find('label').html(x);
					var message=$('#empty_field').html();
					$(this).after(message);
				}
			})
			$('.nav-tabs li a').each(function() {
				var html = $(this).html();
				html = html + '<span style="color:red; display:none"> ?</span>';
				$(this).html(html);
			})
		};
		function hide_message() {
			for (var i in CKEDITOR.instances) {
				CKEDITOR.instances[i].on('change', function() {
					var name = $(this).attr('name');
					var id = '#inner #'+name;
					$(id).next().next().hide(1000);
					$('.nav-tabs li a').each(function() {
						var href=$(this).attr('href');
						if (href=='#tab-2') $(this).find('span').hide(1000);
					})
				});
			}

			$('#inner select, #inner input, #inner textarea').change(function() {
				var visible = $(this).css('visibility');
				var type = $(this).attr('type');
				if (visible=='hidden') {
					if ($(this).val().length!=0) {
						$(this).next().next().hide(1000);
						var tid = 'tab-2';
					}
				}
				else {
					if ($(this).val().length!=0) {
						if ($(this).next().attr('class')=='empty')
							$(this).next().hide(1000);
						var tid = $(this).parent().parent().parent().parent().parent().attr('id');
					}
				}
				$('.nav-tabs li a').each(function() {
					var href=$(this).attr('href');
					tidr='#'+tid;
					if (href==tidr) $(this).find('span').hide(1000);
				})
			})

		}
		// izvrsenje radnje iz modify.php
		function update(link,param) {
			$.ajax({
			type: "POST",
			url: link,
                data: param+'&frontadmin=1',
				success: function(data) {
					$('.backdrop').css("display", "none").empty();
					$('.backdrop').css("display", "block").html(data);
					modify_plugin();
					$('.title-action #promeni').click(function() {
						var name = $(this).attr('name');
						modify(name);
					})
				}
			})
		}
		// vracanje na modify.php nakon izvrsenja radnje u modify.php
		function update2(link,param) {
			$.ajax({
				type: "POST",
				url: link,
                data: param+'&frontadmin=1',
				success: function(data) {
					var klasa = $(data).attr('class');
					toastr[klasa](data);
					var link = window.folder+"/"+'modify.php';
					var param = window.param2;
					update(link,param);
				}
			});
		}

		//potvrdjivanje promena u modify.php
		function modify(action_name) {
			var vf=[];
			$('#vf_cont .vf').each(function() {
				var name=$(this).text();
				vf.push(name);
			})
			var param = '';
			//POST parametri i validacija
			window.error=0;
			//var param=$('#inner').serialize();

			$('#inner select, #inner input, #inner textarea').each(function() {
				if ($(this).attr('name')) {
					var name=$(this).attr('name');
					var visible = $(this).css('visibility');
					var type = $(this).attr('type');
					if (visible=='hidden') {
						var instance = CKEDITOR.instances[name];
						instance.updateElement();
						var value = instance.getData();
					}
					else if (type=='checkbox') {
						var log =	$(this).prop('checked');
						if (log) var value='on';
						else var value = 'off';
					}
					else var value = $(this).val();

					if (jQuery.inArray(name,vf) !== -1 && $(this).attr('type') !== 'hidden' && value.length==0) {
						window.error=1;
						if (visible=='hidden') {
							$(this).next().next().show(1000)
							var tid = 'tab-2';
						}
						else if (type == 'file') {
							$(this).next().show(1000)
							var tid = 'tab-3';
						}
						else {
							$(this).next().show(1000);
							var tid = $(this).parent().parent().parent().parent().parent().attr('id');
						}

						$('.nav-tabs li a').each(function() {
							var href=$(this).attr('href');
							tidr='#'+tid;
							//$(this).find('span').hide();
							if (href==tidr) $(this).find('span').show(1000);
						})
					}
					else {
						if (value.indexOf('&')>-1) value =  value.replace(/&/g,'%26');
						if ($(this).attr('type')=='file' && name !=='obj') {
							var selector = $(this);
							var plugin = window.folder.substr(window.folder.lastIndexOf('/')+1);
							var obj = name.substr(0,3);
							file = plugin + '_' + obj;
							var data = new FormData();
							data.append(file, $(selector).prop('files')[0]);
							$.ajax({
								type: 'POST',
								url: $('#rw').text()+'admin/form_file_get.php',
								data: data,
								async: false,
								processData: false, // Using FormData, no need to process data.
								contentType: false,
									success: function(data) {
										value=data;
									}
							});
						}
						param = param + "&" + name + "=" + value ;
					}
				}
			})
			if (window.error==0) {
				var link = $('#inner').attr('action');
				link = window.folder + '/' + link;
				var webtext = $('input[name ="wb2_1"]').val();
				//alert (webtext);
				//if (webtext!='undefined') alert ('wait');
				if(typeof(webtext)  !== "undefined") toastr['warning']('Wait more than usual'); //prikaz poruke o izvrsenju
				//alert (param);
				var ll = $('#rw').text()+'admin/loader.php';
				$('.backdrop').load(ll);
				$.ajax({
					type: 'POST',
					url: link,
					data: param+'&frontadmin=1',
						success: function(data) {
							var klasa = $(data).attr('class');
							toastr[klasa](data); //prikaz poruke o izvrsenju
							$('.backdrop').css("display", "none").empty();
							var link = window.folder+"/index.php";
							var param = window.param;
							table (link,param);	//vracanje na tabelu u index.php-u , normalan slucaj
						}
				});
			}
		}
		// priprema za tabelu i priprema dogadjaja iz index.php
        function prepare() {
			//brisanje hedera iz admin tabele
			$('.ibox-title').css("display", "none");
			$('.ibox-content').addClass("front");
			$('#main_title').text(window.title);
			$('#main_description').text(window.resdes);

			// za sve
			table_plugin();
            // promena href u data
			$('table a, .pagination a, .dt-buttons a').each(function() {
                if ($(this).attr('href'))
				{
					var href = $(this).attr('href');
					if ($(this).attr('id')!='zip') $(this).removeAttr('href');
					if (href.indexOf('?')>-1)
					{
						$(this).attr('data-link',(href.split('?'))[0]);
						$(this).attr('data-param',(href.split('?'))[1]);
					}
					else
						$(this).attr('data-link',href);
				}
            });

			// preuzimanje poruka
			$('#msg div').each(function() {
                var id = $(this).attr('id');
				window[id] = $(this).text();
            });
            // brisanje onChange
            $('thead select').each(function() {
                $(this).removeAttr('onChange');
            });

			// dogadjaji iz tabele
            $('tbody a, .dt-buttons a, .html5buttons a').click(function() {
				var title = $(this).text();
				var link_b = $(this).attr('data-link');
				link = window.folder+"/"+link_b;
				var param = $(this).attr('data-param');
				window.param2=param;
				var klasa = '';
				var klasa = klasa+$(this).attr('class');
				window.klasa = (klasa.split(' '))[0];
				// ako je dogadjaj delete

				if ((link_b.split('_'))[0]=='delete')
				{
					// prozor za potvrdu brisanja

					swal({
						title: window['MSG_SWAL_1'],
						text: window['MSG_SWAL_2'],
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						cancelButtonText: window['MSG_SWAL_5'],
						confirmButtonText: window['MSG_SWAL_3'],
						closeOnConfirm: false
						},
						function () {
							$.ajax({
								type: "POST",
								url: link,
								data: param+'&frontadmin=1',
								success: function(data) {
										var klasa = $(data).attr('class');
										toastr[klasa](data);
										var msg = $(data).text();
										swal(window['MSG_SWAL_4'], msg, "success");
										var link = window.folder+"/index.php";
										var param = window.param;
										table (link,param);
									}
							});
						}
					);
					//
				}
				// dogadjaj nije delete
				else
				{
					if (window.klasa == 'naziv' || window.klasa=='btn') $('.backdrop').css('display', 'block');
					$.ajax({
						type: "POST",
						url: link,
						data: param+'&frontadmin=1',
						success: function(data) {
							if (window.klasa == 'naziv' || window.klasa=='btn') {
								$('.backdrop').css('display', 'block').html(data);
								//toastr.success(title,window['MSG_TOASTR_2']);
								modify_plugin();
								hide_rows();
								show_star();
								hide_message();
								$('#inner #document').attr('type','file');
								$('#inner #modi_title').text(window.title);
								$('#inner .title-action #promeni').click(function() {
									//$('.backdrop').css("display", "none");
									var name = $(this).attr('name');
									modify(name);
								})
							}
							else
							{
								var klasa = $(data).attr('class');
								toastr[klasa](data);
								var link = window.folder+"/index.php";
								var param = window.param;
								table (link,param);
							}
						}
					});
				}
            })
			// pager
			$('.pagination a').click(function() {
				var link = $(this).attr('data-link');
                link = window.folder+"/"+link;
                var param = $(this).attr('data-param');
				table (link,param);
			})


			// klase za ikonice za sortiranje
			$(".header a").parent().addClass('sorting');
			$("a[data-param$='asc']").parent().addClass('sorting_asc').removeClass('sorting');
			$("a[data-param$='desc']").parent().addClass('sorting_desc').removeClass('sorting');

			//sortiranja
			$('thead a').click(function() {
				var link = $(this).attr('data-link');
                link = window.folder+"/"+link;
                var param = $(this).attr('data-param');
				table (link,param);
            })

			//filtriranja
			$('thead select').change(function() {
                link = window.folder+"/index.php";
				var param = "";
				$('thead select').each(function() {
					var name = $(this).attr('name');
					$(this).attr('id', name);
					var x1 = "thead #"+name+' option:selected';
					var val = $(x1).val();
					param = param + "&" + name + "=" + val;
				});
				param = window.param+param;
				table(link,param);
			});


			// ispitivanje da li se redosled redova cuva u bazi (da li postoji move.php)
			// pomeranje-sortiranje redova tabele
			//move_rows();
			//prebaceno u odgovarajuce table_plugin


			//formatiranje tabele - klizaci
		//	$("#normal").colResizable({
    //            liveDrag: true,
    //            gripInnerHtml: "<div class='grip "+ window.folder +" '></div>",
    //            marginLeft: '-5px',
    //            draggingClass: "dragging",
    //            resizeMode: 'fit',
    //            postbackSafe: true,
    //            partialRefresh: true
    //        });
        };

        //funkcije za vezane resurse
    		function insert_row(obj,type,dir) {
    			var tab = '#normal_'+obj;
    			$(tab + ' #new_obj').click(function() {
    				var div_obj=$(tab + ' #obj_div').html();
    				div_obj="<tr id='active_row'>"+div_obj+"</tr>";
    				$(tab + ' tbody').append(div_obj);

            prepare_rows(obj);
            if (obj=='img' || obj=='doc')
    				{
              var ai = tab + " table #add_obj_"+window_row_num;
				if (obj=='img') $(ai).attr('id','temporaryimgid');
				else $(ai).attr('id','temporarydocid');
				if (obj=='img') var tempid='temporaryimgid';
				else var tempid='temporarydocid';
              $(ai).attr('id','temporaryid');
    				$.fancybox.open({
    					 width		: '900',
    					 height	: '800',
    					 type		: 'iframe',
    					 src   : 'https://www.iawd.at/admin/CKeditor/filemanager/dialog.php?type='+type+'&fldr=/&field_id='+tempid+'&relative_url=1',
    				 autoScale    	: false,
    				 iframe : {
    							 css : {
    									 height : '800px'
    							 }
    						}
    			});

    			$(function() {
    			// Executes a callback detecting changes with a frequency of 1 second
    				 $('#add_obj_'+window_row_num+'').observe_field(1, function() {
    					 var url = $(this).val();
    					 var ai = tab + " table #add_obj_"+window_row_num;
    						if (obj=='img') {
    							var img_html="<img src='" + url +"' />"
    							$(ai).parent().prev().html(img_html);
    						}
    				 });
    			});
        }
    			});
    		}

    		function prepare_rows(obj) {
    			var tab = '#normal_'+obj+' table';
    			var i=1;
    			$(tab + ' #active_row .main').each(function() {
    				//alert ($(this).attr('data-form'));
    				//if ($(this).attr('name') == 'obj')
    				//{
    					var ni=obj+"_"+i;
    					$(this).attr('name',ni);
    					var ai="add_obj_"+i;
    					$(this).attr('id',ai);
            //  window_row_num=i;
    					i++;
    				//}
    			})
    			var k=1;
    			$(tab + ' #active_row .description').each(function() {
    				//if ($(this).attr('name') == 'des')
    				//{
    					var ni="des_"+k;
    					$(this).attr('name',ni);
    					var ai="add_des_"+k;
    					$(this).attr('id',ai);
    					k++;
    				//}
    			})
    			var k=1;
    			$(tab + ' #active_row select').each(function() {
    				var ni="lng_"+k;
    				$(this).attr('name',ni);
    				var ai="add_lng_"+k;
    				$(this).attr('id',ai);
    				k++;
    			})
          window_row_num=i-1;

    			var j=1;
    			$(tab + ' #active_row .btn').each(function() {
    				var di="del_obj_"+j;
    				$(this).attr('id',di);
    				//event delete row
    				$(this).click(function() {
    				$(this ).parent().parent().remove();
    				prepare_rows(obj);
    				});
    				j++;
    			})

    			// event move rows
    			$(tab + ' tbody').attr('id', 'tabledivbody2');
    			$(tab + ' #tabledivbody2 tr').addClass('sectionsid');
    			$(tab + ' #tabledivbody2 tr').hover(function() {
    				$(this).toggleClass('highlight');
    			});
    			$(tab + ' #tabledivbody2').sortable({
    				revert: true,
    				items: 'tr:not(#obj_div)',
    				axis: 'y',
    				cursor: 'move',
    				opacity: 0.6,
    				update: function() {
    					prepare_rows(obj);
    				}
    			});
    			$(tab + ' #tabledivbody2 tr').disableSelection();
    		}

    		//brisanje vezanih konektovanih resursa
    		function delete_conres() {
    			$('table #delete_res').click(function() {
    				link = 'delete_conres.php';
    				var param = $(this).attr('data-param');
    				var mode = $('#mode').val();
    				window.param2= param + '&active=3 &mode=' +mode + param_add() + '&cnc=1';
    				update2(link,param);
    			})
    		}



    		// funkcije za slike i dokumente

    		function BrowseServer(field)
        {
          $.fancybox.open({
           width		: '900',
           height	: '800',
           type		: 'iframe',
           src   : 'https://www.iawd.at/admin/CKeditor/filemanager/dialog.php?type=1&fldr=/&field_id=slika&relative_url=1',
           autoScale    	: false,
           iframe : {
               css : {
                      height : '800px'
                      }
                    }
          });
          $(function() {
          			// Funkcija gleda promenu polja #slika i izvrsava dodavanje src slike u klasu
          				 $("#slika").observe_field(1, function( ) {
          					 $('.image').attr('src',this.value).show();
          				 });
          			});
    		}

    		function BrowseServerImage(field)
        {
          $.fancybox.open({
           width		: '900',
           height	: '800',
           type		: 'iframe',
           src   : 'https://www.iawd.at/admin/CKeditor/filemanager/dialog.php?type=1&fldr=/&field_id=image&relative_url=1',
           autoScale    	: false,
           iframe : {
               css : {
                      height : '800px'
                      }
                    }
          });
          $(function() {
                // Funkcija gleda promenu polja #slika i izvrsava dodavanje src slike u klasu
                   $("#image").observe_field(1, function( ) {
                     $('.img_preview').attr('src',this.value).show();
                   });
                });
    		}

    		function ViewImageData() {
    			// otvaranje forme za unos i punjenje sa podacima iz mysql tabele

    		}

    		function CheckImageData() {
    			// punjenje atributa title i alt sa sadrzajem iz mysql tabele

    		}
    		// dogadjaj za editovanje podataka slike
    		function BrowseImageData()
    		{


    		}


    		function BrowseFileServer(field)
        {
          $.fancybox.open({
           width		: '900',
           height	: '800',
           type		: 'iframe',
           src   : 'https://www.iawd.at/admin/CKeditor/filemanager/dialog.php?type=2&fldr=/&field_id=dokument&relative_url=1',
           autoScale    	: false,
           iframe : {
               css : {
                      height : '800px'
                      }
                    }
          });
    		}
