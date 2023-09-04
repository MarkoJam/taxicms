//pripremne radnje
 $(document).ready(function() {
	//if (location.protocol !== "https:") location.protocol = "https:";
	start_counting() ;
	window.gpid=0;
	window.folder='plg_dashboard';
	 setTimeout(function() {
		 toastr.options = {
			 closeButton: true,
			 progressBar: true,
			 showMethod: 'slideDown',
			 timeOut: 4000
		 };
		 toastr.success(window['MSG_TOASTR_1'], window['MSG_TOASTR_3']);
	 }, 1300);

	 // pocetno sakrivanje stabla stranica i grupa proizvoda
	 $('#page-left').hide();
	 $('#group-left').hide();
	 $('#left').hide();
	 $('#right').attr('class', "col-lg-12");

	table('plg_dashboard/index.php');// ucitavanje pokaznog menija
	prepare_left_menu();	//priprema levog menija
 });

//zatvaranje prozora
 $(document).on('click', '.close-modal', function() {
	 $('.backdrop').css("display", "none").empty();
 });

// dogadjaji iz glavnog menija
	 // a tag link
	$('#side-menu a').click(function() {
		 var title = $(this).text();
		 window.class1 = $(this).attr('data-class');
		 $('#title').html(title); // naslovi za desno
		 $('#title2').html(title);
		 window.title= title;
		 //loader
		 $('.table-responsive').load('loader.php');

		//leva navigacija
		   // MetisMenu
			$('#side-menu').metisMenu();
			//Popravka za meni kad nema submeni

		$('#side-menu > li:not(:has(ul))').click(function(){
			if($('#side-menu > li:has(> ul)').length) {
				$('li').removeClass("active");
				$('#side-menu > li:has(> ul) > a').attr('aria-expanded', 'false');
				$('#side-menu > li:has(> ul) > ul').attr('aria-expanded', 'false').removeClass("in");
			}
			$(this).addClass("active");
		});
		$('#side-menu > li:has(> ul)').click(function(){
			$('#side-menu > li:not(:has(ul))').removeClass("active");
		});

		//skrivanje i prikazivanje za levu navigaciju
		if ($(this).attr('id')=='page_id') {
			 $('#page-left').show();
			 $('#group-left').hide();
			 window.left='page';
		}
		else
		if ($(this).attr('id')=='grupaproizvodaid') {
			 $('#page-left').hide();
			 $('#group-left').show();
			 window.left='grupaproizvod';
		}
		else {
			 window.left='none';
		};
		// sirenje i skupljanje u zavisnosti da li ima leve navigacije
		if ($(this).attr('data-param')) {
			 $('#left').show();
			 $('#right').attr('class', "col-lg-9");
		} else {
			 $('#left').hide();
			 $('#right').attr('class', "col-lg-12");
		}
		// priprema za izvrsenje stavke glavnog menija
		 window.folder = $(this).attr('data-folder');
		 var param = $(this).attr('data-param');
		 window.param = param;
		 var link = window.folder+"/index.php";
		 table(link,param); //izvrsenje stavke, ucitavanje tabele iz index.php
	});
	//pamcenje i oznacavanje u levoj navigaciji
		function prepare_left_menu () {
			$("#PageNavigation-Horizontal").jstree({
                 "state": {
                     "key": 'impulst2'
                 },
                 "plugins": ["state"]
             });
             $("#grupaProizvodaNav").jstree({
                 "state": {
                     "key": "impulst"
                 },
                 "plugins": ["state"]
             });
		};

	// dogadjaj na klik iz leve navigacije
	 $(document).on('click', '.jstree-anchor', function() {
		window.param = $(this).attr('data-param');
		var link = $(this).attr('data-link');
		table(link,param);
	 });
//kraj leva navigacija
	//brisanje cashe-a
	$('#cashe').click(function() {
		$.ajax({
			url: "../delete_html.php",
		});
	})
// funkcije

	// pomeranje redova
	function move_rows(arg) {
		$('#normal tbody').attr('id', 'tabledivbody');
		$('#tabledivbody tr').addClass('sectionsid');
		$('#tabledivbody tr').hover(function() {
			$(this).toggleClass('highlight');
		});
		$('#tabledivbody').sortable({
			revert: true,
			items: 'tr:not(.header)',
			axis: 'y',
			cursor: 'move',
			opacity: 0.6,
			update: function() {
				sendOrderToServer(arg);
			}
		});
		$('#tabledivbody tr').disableSelection();

		// section id za upisivanje u sql tabelu
		$('#normal tr').each(function() {
			if (!($(this).attr('class')=='header')) {
				var id=($(this).children('td:first').children('a').attr('href'));
				if (id)
				{
					id=(id.split('?'))[1];
					id = id.substr(id.lastIndexOf("=")+1);
					id= 'sectionsid_'+id;
					$(this).attr('id',id);
				}
			}
		});

		// belezenje redosleda u bazu
		function sendOrderToServer(arg) {
			var link = window.folder+'/move.php';
			if (arg) var nc='&ncid='+arg;
			else var nc='';
			var order = $('#tabledivbody').sortable('serialize')+nc+'&'+window.param;
		console.log(link+'?'+order);

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: link,
				data: order,
			});
		}
		// pomeranje redova gore-dole
		$(".moveuplink").click(function() {
			$(this).parents(".sectionsid").insertBefore($(this).parents(".sectionsid").prev());
			sendOrderToServer();
		});
		$(".movedownlink").click(function() {
			$(this).parents(".sectionsid").insertAfter($(this).parents(".sectionsid").next());
			sendOrderToServer();
		});
	};


// desno glavno
// izvresnje tabele u index.php
		function table(link,param) {
			console.log(link+'?'+param);
		    $.ajax({
                type: 'POST',
                url: link,
                data: param,
                    success: function(data) {
                        $('#right').html(data);
                        prepare();
                    }
            });
			// uslovno azuriranje leve navigacije ukoliko postoji tree.php
				var link = window.folder + '/tree.php' ;
				if (window.left=='page') {
					var nav_id='#PageNavigation-Horizontal';
					var title=window['MSG_NANE_1'];
				}
				if (window.left=='grupaproizvod') {
					var nav_id='#grupaProizvodaNav';
					var title=window['MSG_NANE_2'];
				}
				$.ajax({
					type: 'POST',
					url: 'file_exist.php',
					data: 'file='+link,
						success: function(data) {
							if (data !="")
							{
								$(nav_id).jstree(true).settings.core.data = data;
								$(nav_id).jstree(true).refresh();
								$('#left .ibox-title h5').html(title);
							}
						}

				});
		}
		// izvrsenje radnje iz modify.php
		function update(link,param) {
			console.log(link+'?'+param);
			$.ajax({
			type: "POST",
			url: link,
			data: param,
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
			console.log(link+'?'+param);
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				success: function(data) {
					var klasa = $(data).attr('class');
					toastr[klasa](data);
					var link = window.folder+"/"+'modify.php';
					var param = window.param2;
					update(link,param);
				}
			});
		}

		function validate (name) {
			modify(name);
		}

		//potvrdjivanje promena u modify.php
		function param_add() {
			$('input').removeAttr('disabled');
			$('#inner textarea').each(function() {
				var name = $(this).attr('name');
				var visible = $(this).css('visibility');
				if (visible=='hidden') {
					var instance = CKEDITOR.instances[name];
					instance.updateElement();
					var value = instance.getData();
				}
			})
			var param=$('#inner').serialize();
			console.log (param);
			return param;
		}
		function modify(action_name) {
			var param = '';
			var param=param_add();
			//za promenu vrste stranice
			if (action_name=='pretvori_u_stranicu') param = param + "&pretvori=stranica";
			if (action_name=='pretvori_u_kategoriju') param = param + "&pretvori=kategorija";
			$.ajax({url: "../delete_html.php",});

			// uslov zbog prelaska na ayuriranje proizvoda iz tabele proizvoda u modify za grupe proizvoda
			var link = $('#inner').attr('action');
			link = window.folder + '/' + link;
			console.log(link+'?'+param)
			$('.table-responsive').load('loader.php');
			$.ajax({
                type: 'POST',
                url: link,
                data: param,
                    success: function(data) {
						var klasa = $(data).attr('class');
						toastr[klasa](data); //prikaz poruke o izvrsenju
						$('.backdrop').css("display", "none").empty();
						var link = window.folder+"/index.php";
						var param = window.param;
						$('#cashe').trigger("click");
						table (link,param);	//vracanje na tabelu u index.php-u , normalan slucaj
                    }
            });
		}
		// priprema za tabelu i priprema dogadjaja iz index.php
        function prepare() {
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
            $('tbody a, .dt-buttons a, .html5buttons a,  .sinhro a').click(function() {
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
								data: param,
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
					$.ajax({url: "../delete_html.php",});
				}
				// dogadjaj nije delete
				else
				{
					if (window.klasa == 'naziv' || window.klasa=='btn') $('.backdrop').css('display', 'block');
					$.ajax({
						type: "POST",
						url: link,
						data: param,
						success: function(data) {
							if (window.klasa == 'naziv' || window.klasa=='btn') {
								$('.backdrop').css('display', 'block').html(data);
								//toastr.success(title,window['MSG_TOASTR_2']);
								modify_plugin();

								$('#inner #modi_title').text(window.title);
								$('#inner .title-action #promeni').click(function() {
									$('.backdrop').css("display", "none");
									var name = $(this).attr('name');
									validate(name);
								})
								$('.new-action #comment').click(function() {
									var link = "plg_comment/index.php";
									var resurs = $(this).attr('data-param');
									window.folder = 'plg_comment';
									var x = '#inner #'+resurs+'_id';
									var res_id = $(x).val();
									var param = 'resurs='+resurs+'&resid='+res_id;
									$('.backdrop').css("display", "none").empty();
									table (link,param);	//vracanje na tabelu u index.php-u



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
			// potvrda filtera
			$('#search_filter .submitButton').click(function() {
                link = window.folder+"/index.php";
				var param = "&search="+$('#search_filter input').val();
				param = window.param+param;
				table(link,param);
			});
			// ponistavanje filtera
			$('#search_filter .cancel').click(function() {
                link = window.folder+"/index.php";
				var param = "&cancel=Yes";
				param = window.param+param;
				table(link,param);
			});

			// Collapse ibox function
			$('.collapse-link').on('click', function () {
				var ibox = $(this).closest('div.ibox');
				var button = $(this).find('i');
				var content = ibox.children('.ibox-content');
				content.slideToggle(200);
				button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
				ibox.toggleClass('').toggleClass('border-bottom');
				setTimeout(function () {
					ibox.resize();
				}, 50);
			});

			// Fullscreen ibox function
			$('.fullscreen-link').on('click', function () {
				var ibox = $(this).closest('div.ibox');
				var button = $(this).find('i');
				$('body').toggleClass('fullscreen-ibox-mode');
				button.toggleClass('fa-expand').toggleClass('fa-compress');
				ibox.toggleClass('fullscreen');
				setTimeout(function () {
					$(window).trigger('resize');
				}, 100);
			});

			// Close ibox function
			$('.close-link').on('click', function () {
				var content = $(this).closest('div.ibox');
				content.remove();
			});

			// ispitivanje da li se redosled redova cuva u bazi (da li postoji move.php)
			// pomeranje-sortiranje redova tabele
			//move_rows();
			//prebaceno u odgovarajuce table_plugin


			//formatiranje tabele - klizaci
			$("#normal").colResizable({
              liveDrag: true,
              gripInnerHtml: "<div class='grip'></div>",
              marginLeft: '-5px',
              draggingClass: "dragging",
              resizeMode: 'fit',
              postbackSafe: true,
              partialRefresh: true,
              useLocalStorage: true,
              minWidth: 60
            });
        };

		//funkcije za vezane resurse
		//funkcije za vezane resurse
		function insert_row(obj,type,dir) {
			var tab = '#normal_'+obj;
			$(tab + ' #new_obj').click(function() {
				var div_obj=$(tab + ' #obj_div').html();
				div_obj="<tr id='active_row'>"+div_obj+"</tr>";
				$(tab + ' tbody').append(div_obj);

				prepare_rows(obj);
				if (obj=='img' || obj=='doc' || obj=='dc2'){
					var ai = tab + " table #add_obj_"+window_row_num;
					if (obj=='img') $(ai).attr('id','temporaryimgid');
					else $(ai).attr('id','temporarydocid');
					if (obj=='img') var tempid='temporaryimgid';
					else var tempid='temporarydocid';
					console.log('CKeditor/filemanager/dialog.php?type='+type+'&fldr='+dir+'&field_id='+tempid+'&relative_url=1');

					$.fancybox.open({
						width		: '900',
						height	: '800',
						type		: 'iframe',
						src   : 'CKeditor/filemanager/dialog.php?type='+type+'&fldr='+dir+'&field_id='+tempid+'&relative_url=1',
						autoScale    	: false,
						iframe : {
							 css : {
									 height : '800px'
							 }
						}
					});
					$(function() {
						// Executes a callback detecting changes with a frequency of 1 second
						$('#temporaryimgid').observe_field(1, function() {
							var url = $(this).val();

							var ai = tab + " table #add_obj_"+window_row_num;
							if (obj=='img') {
								var img_html="<a data-toggle='modal' data-target='#myModal7'><img class='image-title' src='" + url +"' /><div class='overlay-icon'></div></a>"
								$('#temporaryimgid').parent().prev().html(img_html);
								CheckImageData();
								ViewImageData();
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
				//if ($(this).attr('type') !== 'hidden')
				//{
					var ni=obj+"_"+i;
					$(this).attr('name',ni);
					var ai="add_obj_"+i;
					$(this).attr('id',ai);
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
       src   : 'CKeditor/filemanager/dialog.php?type=1&fldr=images&field_id=slika&relative_url=1',
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
                 CheckImageData();
               });
            });
    }
    function BrowseServerSlika(field)
    {
      $.fancybox.open({
       width		: '900',
       height	: '800',
       type		: 'iframe',
       src   : 'CKeditor/filemanager/dialog.php?type=1&fldr=images&field_id=slikaover&relative_url=1',
       autoScale    	: false,
       iframe : {
           css : {
                  height : '800px'
                  }
                }
      });
      $(function() {
            // Funkcija gleda promenu polja #slika i izvrsava dodavanje src slike u klasu
               $("#slikaover").observe_field(1, function( ) {
                 $('.imageover').attr('src',this.value).show();
                 CheckImageData();
               });
            });
    }

    function BrowseServerImage(field)
    {
      $.fancybox.open({
       width		: '900',
       height	: '800',
       type		: 'iframe',
       src   : 'CKeditor/filemanager/dialog.php?type=1&fldr=images&field_id=image&relative_url=1',
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
    function BrowseServerVideo(field)
    {
      $.fancybox.open({
       width		: '900',
       height	: '800',
       type		: 'iframe',
       src   : 'CKeditor/filemanager/dialog.php?type=2&fldr=File&field_id=slika&relative_url=1',
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
                 $('.video').attr('src',this.value).show();
               });
            });
    }


    function ViewImageData() {
			// otvaranje forme za unos i punjenje sa podacima iz mysql tabele
			$('img.image-title').click(function(){
				var image_url = $(this).attr('src');
				var type = $(this).attr('data-type');
				param = {image_url: image_url, type: type};
				link = 'plg_images/view_image_data.php';
				$.ajax({
					type: "POST",
					url: link,
					data: param,
					dataType: "json",
					success: function(data) {
						console.log(data);

						$("#image-title").val( data.title );
						$("#descript").val( data.descript );
						$("#url").val( data.url );
						$("#type").val( data.type );
					}
				})
			})
		}

		function CheckImageData() {
			// punjenje atributa title i alt sa sadrzajem iz mysql tabele
			var index=1;
			$('img.image-title').each(function() {
				var idp='imgid'+index;
				$(this).attr('id',idp);
				var param = 'src='+$(this).attr('src')+'&index='+index;
				index++;
				$.ajax({
					type: "POST",
					url: 'plg_images/check_image_data.php',
					data: param,
						success: function(data) {
							var res = data.split('/');
							var ids ='#imgid'+res[0];
							if (res.length == 3) {
								$(ids).attr('title',res[1]);
								$(ids).attr('alt',res[2]);
								$(ids).removeClass('image-title-non');
							}
							else {
								// ove ubaciti uslov preko zadate klase
								$(ids).addClass('image-title-non');
							}
						}
				})
			})
		}
		// dogadjaj za editovanje podataka slike
		function BrowseImageData()
		{

			if (!$('.image-modal').length ) { // da li je vec formiran modal box
				$.ajax({
					type: "POST",
					url: 'plg_images/edit_image_data.php', // forma za unos podataka za sliku
						success: function(data) {
							$('form').append(data); // dodvanje html-a za modal box formiranog u edit_image.php i edit_image.tpl
							$('.modal-footer #promeni').click(function() {// submit forme
								var link = 'plg_images/save_image_data.php';
								var image_url = $('#url').val();
								var title = $('#image-title').val();
								var description = $('#description').val();
								param = "image_url=" + image_url + "&title=" + title + "&description=" + description;
								console.log(param);
								$.ajax({  //cuvanje podataka iz forme
									type: "POST",
									url: link,
									data: param,
									async: false,
									success: function(data) {
										console.log(data);
										CheckImageData();
										var klasa = $(data).attr('class');
										toastr[klasa](data);
										$('#myModal7 #close_pass').trigger( "click" );
									}
								})
							})
						}
				})
			}

			CheckImageData();

			ViewImageData();
		}

    function BrowseFileServer(field)
      {
        $.fancybox.open({
         width		: '900',
         height	: '800',
         type		: 'iframe',
         src   : 'CKeditor/filemanager/dialog.php?type=2&fldr=documents&field_id=dokument&relative_url=1',
         autoScale    	: false,
         iframe : {
             css : {
                    height : '800px'
                    }
                  }
        });
  		}

		//funkcije za izlogovanje
			function start_counting() {
			//	$.ajax({
			//		type: "POST",
			//		data: '',
			//		url: 'stay_login.php',
			//		success: function(data) {}
		//		});
				clearTimeout(window.timeout);
				clearTimeout(window.timeout2);
				window.timeout = setTimeout(count_end, 1240000);
			}
			function count_end() {
				swal({
					title: window['MSG_SWAL_6'],
					text: window['MSG_SWAL_7'],
					type: "warning",
					showCancelButton: false,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: window['MSG_SWAL_8'],
					closeOnConfirm: true
					}
				);
				window.timeout2 = setTimeout(log_out, 60000);
			}
			function log_out() {
				swal.close();
				document.location.href ="index.php?action=logout";
			}
		$('*').bind('mousemove keydown scroll click', function() {
			start_counting() ;
    //console.log('krece se');
		});
