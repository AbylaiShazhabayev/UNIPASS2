var tableUsuariosDisponiveis,checkAdicionarUsuario;function carregarUsuariosDisponiveis(){tableUsuariosDisponiveis.block(),tableUsuariosDisponiveis.api().ajax.url("api/passwords/"+senhaId+"/users/available").load(function(){tableUsuariosDisponiveis.unblock()})}$("#btnUsuariosAdicionar").click(function(){$("#modalUsuariosDisponiveis").modal("show"),carregarUsuariosDisponiveis(),checkAdicionarUsuario=[]}),(tableUsuariosDisponiveis=$("#tableUsuariosDisponiveis").dataTable({autoWidth:!1,order:[1,"asc"],deferLoading:0,buttons:[],columns:[{data:"id",orderable:!1,render:function(a){return'<label class="custom-control custom-checkbox m-0"><input type="checkbox" class="custom-control-input btnCheckUsuario" data-id="'+a+'"><span class="custom-control-label">&nbsp;</span></label>'}},{data:"name",width:"45%"},{data:"id",width:"55%",orderable:!1,render:function(a){return'<div data-user="'+a+'"><label class="custom-control custom-checkbox custom-control-inline mb-0"><input type="checkbox" class="custom-control-input" name="can_view" checked disabled><span class="custom-control-label">View</span></label><label class="custom-control custom-checkbox custom-control-inline mb-0"><input type="checkbox" class="custom-control-input" name="can_edit"><span class="custom-control-label">Edit</span></label><label class="custom-control custom-checkbox custom-control-inline mb-0"><input type="checkbox" class="custom-control-input" name="can_delete"><span class="custom-control-label">Delete</span></label><label class="custom-control custom-checkbox custom-control-inline mb-0"><input type="checkbox" class="custom-control-input" name="can_share"><span class="custom-control-label">Share</span></label></div>'}}],drawCallback:function(){$("#tableUsuariosDisponiveis").find('input[name="can_view"], input[name="can_edit"], input[name="can_delete"], input[name="can_share"]').on("change",function(){let a=$(this).parents("div"),e=a.attr("data-user");checkAdicionarUsuario=checkAdicionarUsuario.filter(function(s){return s.user_id==e&&(s.can_view=a.find('input[name="can_view"]').is(":checked")?1:0,s.can_edit=a.find('input[name="can_edit"]').is(":checked")?1:0,s.can_delete=a.find('input[name="can_delete"]').is(":checked")?1:0,s.can_share=a.find('input[name="can_share"]').is(":checked")?1:0),!0})})}})).on("click","tbody > tr .btnCheckUsuario",function(){var a=$(this).attr("data-id");$(this).is(":checked")?checkAdicionarUsuario.push({password_id:senhaId,user_id:a,can_view:$(this).parents("tr").find('input[name="can_view"]').is(":checked")?1:0,can_edit:$(this).parents("tr").find('input[name="can_edit"]').is(":checked")?1:0,can_delete:$(this).parents("tr").find('input[name="can_delete"]').is(":checked")?1:0,can_share:$(this).parents("tr").find('input[name="can_share"]').is(":checked")?1:0}):checkAdicionarUsuario=checkAdicionarUsuario.filter(function(e){return e.user_id!=a}),$("#btnUsuariosSalvar").toggleClass("disabled",0===checkAdicionarUsuario.length)}),$("#btnUsuariosSalvar").click(function(){let a="shareds="+JSON.stringify(checkAdicionarUsuario),e=$("#modalUsuariosDisponiveis"),s=e.find(".modal-content");s.block(),$.request({url:"api/passwords/"+senhaId+"/shareds",method:"POST",data:a,error:function(){s.unblock()},after:function(){$.notify({message:"Password shared"},{type:"success"}),carregarCompartilhamentos(),e.modal("hide"),s.unblock()}})});