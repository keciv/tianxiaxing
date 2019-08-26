var member_id = $('#member_id').val();
$(function() {
	pullOnLoad();
	TotalPrice();
	shuliang();
	//	koncat();
});
//加的效果
$("#scroller").on('click', '.product-add', function() {
	var n = $(this).prev().val();
	var num = parseInt(n) + 1;
	if(num == 99) {
		return;
	}
	$(this).prev().val(num);
	TotalPrice();

	var newid = $(this).parents('.product').attr('id');
	console.log(newid)
	var newcount = $(this).prev().val();
	console.log(orderArr)
	var obj = orderArr.find(function(fn) {
		return fn.pro === newid;
	})
	console.log(obj);
	obj.count = newcount

})
//减的效果
$("#scroller").on('click', '.product-jian', function() {
	var n = $(this).next().val();
	var num = parseInt(n) - 1;
	if(num == 0) {
		return;
	}
	$(this).next().val(num);
	TotalPrice();

	var newid = $(this).parents('.product').attr('id');
	var newcount = $(this).next().val();

	var obj = orderArr.find(function(fn) {
		return fn.pro === newid
	})
	obj.count = newcount
	console.log(orderArr)
});

//  商品
$("#scroller").on('click', '.product-ckb', function() {
	$(this).children("em").toggleClass("product-xz");
	var $plength = $(this).parents('.bodyItem').children('.product').length;
	var $emlength = $(this).parents('.bodyItem').find('.product .product-xz').length;
	if($plength == $emlength) {
		$(this).parents('.bodyItem').find('.shop em').addClass('product-xz1')
	} else {
		$(this).parents('.bodyItem').find('.shop em').removeClass('product-xz1')
	}
	TotalPrice();
	productxz();
});
//	店铺
$("#scroller").on('click', '.bodyItem .shop em', function() {
	var className = $(this).attr('class');
	if((className == '') || (className == undefined)) {
		$(this).addClass("product-xz1");
		$(this).parents('.bodyItem').find('.product-ckb em').addClass("product-xz");
	} else {
		$(this).removeClass("product-xz1");
		$(this).parents('.bodyItem').find('.product-ckb em').removeClass("product-xz");
	}
	TotalPrice();
	productxz();
});

//全选产品
$(".product-al").click(function() {
	var fxk = $(".product-em");
	var qx = $(".product-all em");
	qx.toggleClass("product-all-on");
	if($(this).find(".product-all em").is(".product-all-on")) {
		fxk.addClass("product-xz");
		$('.shop em').addClass("product-xz1");
	} else {
		fxk.removeClass("product-xz");
		$('.shop em').removeClass("product-xz1");
	}
	TotalPrice();
	shuliang()
});
//删除产品
//	$(".product-del").click(function(){
//		if(confirm("您确定要删除当前商品？")){
//			$(this).closest(".product-box").remove();
//		}
//		
//		koncat();
//		TotalPrice();
//	});

//选中产品
function productxz() {
	var xz = $(".product-em");
	var xz1 = $(".product-xz");
	if(xz1.length == xz.length) {
		$(".product-all em").addClass("product-all-on");
	} else {
		$(".product-all em").removeClass("product-all-on");
	}
	shuliang();
	TotalPrice();

}

//计算产品价格
function TotalPrice() {
	//总价
	var total_price = 0;
	var total_jifen = 0;
	$(".product-em").each(function() {

		if($(this).is(".product-xz")) {
			var slproice = Number($(this).parents(".product-ckb").siblings().find(".product-num").val()); //得到产品数量
			var price = Number($(this).parents(".product-ckb").siblings().find(".price").text()); //得到产品单价
			var xiaoji_price = 0;
			var xiaoji_jifen = 0;
			if($(this).parents(".product-ckb").siblings().find(".jifen")) {
				jifen = $(this).parents(".product-ckb").siblings().find(".jifen").text(); //得到产品单价
				xiaoji_jifen = jifen * slproice;
			}
			xiaoji_price = price * slproice;
			total_price += xiaoji_price;
			total_jifen += xiaoji_jifen;
		}
		$(".all-price").text(total_price); //输出全部总价
		$(".all-jifen").text(total_jifen); //输出全部总价
	});

}
//获取选择产品数量
function shuliang() {
	$(".product-all-sl").text("");
	var cd = $(".product-xz").length;
	$(".product-all-sl").text(cd);

	if(cd > 0) {
		$(".product-all-qx").text("已选");
		$(".all-sl").css("display", "inline-block");
		$(".product-sett").removeClass("product-sett-a");
	} else {
		$(".product-all-qx").text("全选");
		$(".all-sl").css("display", "none");
		//		$(".product-sett").addClass("product-sett-a");
	}
}
//购物车空
function koncat() {
	var pic = $(".product-box").length;
	if(pic <= 0) {
		$(".all-price").text("0.00");
		$(".product-all-qx").text("全选");
		$(".all-sl").css("display", "none");
		$(".product-sett").addClass("product-sett-a");
		$(".product-all em").removeClass("product-all-on");
		$(".kon-cat").css("display", "block");
	} else {
		$(".kon-cat").css("display", "none");
	}
}

//管理
$('.tzq_head .right').on('click', function() {
	var clsass = $(this).attr('class');
	if(clsass == 'fr right del') {
		$("#lpkdel").text('立即付款');
		$(this).removeClass('del');
		$('.all-product-a1').show();
	} else {
		$(".product-sett").removeClass("product-sett-a");
		$("#lpkdel").text('删除');
		$(this).addClass('del');
		$('.all-product-a1').hide();
		//	$(".product-ckb em").removeClass('product-xz')
		//	$(".product-js .product-all em").removeClass('product-all-on')
	}

})

//删除
$('#lpkdel').on('click', function() {
	var Text = $(this).text();
	var newarr = [];
	var total = [];
	if(Text == '删除') {
		var list = $('.product-ckb .product-xz');

		for(var i = 0; i < list.length; i++) {
			var listid = list.eq(i).parents('.product').attr('id')
			total.push(listid)
		}
		var str = total.join(',')

		console.log(str)

		if(list.length == 0) {
			layer.confirm('请选择要删除的商品？', {
				title: false,
				closeBtn: false,
				shade: [0.6],
				btn: ['确定']
			})
			//			if(confirm("请选择要删除的商品")) {}
		} else {

			layer.confirm('确定要删除商品吗？', {
				title: false,
				closeBtn: false,
				shade: [0.6],
				btn: ['确定', "取消"],
				success: function(layero, index) {
					$(".layui-layer-btn0").on("click", function() {

						$.ajax({
							type: "post",
							url: "app.php/ShoppingCart/delete",
							dataType: "json",
							data: {
								member_id: member_id,
								id: str
							},
							success: function(data) {
								console.log(data)

								if(data.code == "200") {
									for(var i = 0; i < list.length; i++) {
										if(list.eq(i).parents('.bodyItem').find(".product").length === 1) {
											list.eq(i).parents('.bodyItem').remove();
										} else {
											list.eq(i).parents('.product').remove();
										}
										koncat();
									}

									TotalPrice();
									layer.msg("已删除", {
										time: 1000
									}, function() {

										//										window.location.reload();
									})

								} else {
									layer.msg(data.msg);
								}

							}
						})
					})
				},
				end: function() {

				}
			})

		}

	} else {

	}

})
var orderArr = [];
var myscroll = new iScroll("wrapper", {
	onScrollMove: function() { //拉动时
		//上拉加载
		if(this.y < this.maxScrollY) {
			$(".pull-loading").html("释放加载");
			$(".pull-loading").addClass("loading");
		} else {
			$(".pull-loading").html("上拉加载");
			$(".pull-loading").removeClass("loading");
		}
	},
	onScrollEnd: function() { //拉动结束时
		//上拉加载
		if($(".pull-loading").hasClass('loading')) {
			$(".pull-loading").html("加载中...");
			pullOnLoad();
		}
	},
	onRefresh: function() {
		$('.pull-loading').html("上拉加载");
	}
});

//上拉加载函数,ajax
var num = 0;
var page = 5; //每次加载4条
var lpk = 1;

function pullOnLoad() {
	setTimeout(function() {

		$.ajax({
			url: "/app.php/ShoppingCart/getData",
			type: "get",
			dataType: 'json',
			data: {
				member_id: member_id,
				CurrentPage: lpk,
				//							当前页
				paginalNum: page,
				//							一页显示数量
			},
			success: function(data) {

				if(data.code == 200) {
					console.log(data)
					var result = "";
					var shops = data.data.shop;

					if(shops.length > 0) {
						for(var i=0;i<shops.length;i++)
						{
							var shop = shops[i];
							var rows = shop.rows;
							rows.forEach(fn => {
								var obj = {};
								obj.pro = fn.id;
								obj.store_id = fn.store_id;
								obj.id = fn.product_id;
								obj.count = fn.count;
								var newspec = fn.spec
								var datastr = JSON.parse(newspec);
								obj.spec = datastr;
								orderArr.push(obj);
							})

							var productItem = '';
							var member_type = $('#member_type').val();
							for(var j = 0;  j< rows.length; j++) {
								var row = rows[j];
								var jsonObj = row.spec;
								var newStr = '';
								if(jsonObj)
								{
									var abc = JSON.parse(jsonObj);
									for(var prop in abc) {
										newStr += abc[prop] + '  ';
									}
								}
								var price = "";
								var price_type = row.current_price;
								price_type = price_type.split("+");
								price_yuan = price_type[0];
								price_jifen = price_type[1];

								var price_html = "";
								if(member_type == "0") {
									price_html = `<span class="product-price">¥&thinsp;<span class="price">${price_yuan}</span></span>`;
								} else if(member_type == "1") {
									price_html = `<span class="product-price">¥&thinsp;<span class="price">${price_yuan}</span>+<span class="jifen">${price_jifen}</span>积分</span>`;
								} else if(member_type == "2") {
									price_html = `<span class="product-price">¥&thinsp;<span class="price">${price_yuan}</span>+<span class="jifen">${price_jifen}</span>积分</span>`;
								}
								productItem += `
										<div class="product" id=${row.id} >
											<div class="product-box clearfix">
												<div class="product-ckb"><em class="product-em "></em></div>
												<div class="product-sx">
													<a href="javascript:;">
														<img src=${row.picture} class="product-img" />
														<span class="product-name">${row.title}</span>
														<span class="product-name1">${newStr}</span>
													</a>
													${price_html}
													<div class="product-amount">
														<div class="product_gw">
															<em class="product-jian">-</em>
															<input type="text" value=${row.count} class="product-num" />
															<em class="product-add">+</em>
														</div>
													</div>
												</div>
											</div>
										</div>
										`

							}

							result += `
	                              		<div class="bodyItem">
											<div class="shop">
												<a href="javascript:;"><em class=""></em><span> ${shop.store_name}</span> <span class="fr glyphicon glyphicon-menu-right"></span></a>
											</div>
											${productItem}
										</div>		
										`
						}
						$("#scroller section").append(result);
						lpk++;
						myscroll.refresh();
						
					} 
					else {
						console.log(1)
						$(".pull-loading").text("没有了");
					}
				} 
				else {
					layer.msg(data.msg)
				}

			},
			error: function() {
				console.log("出错了");
			}
		});

		myscroll.refresh();

	}, 1000);
}

//付款
$('#lpkdel').on('click', function() {

	var yzlength = $('.product-xz').length;
	var Text = $(this).text();
	if(yzlength == 0) {
		layer.msg('请选择')

	} else {
		if(Text == '立即付款') {
			var lpknewarr = [];
			// console.log(orderArr);
			//已选的产品
			var idList = $('.product-xz').parents('.product');

			for(var i = 0; i < idList.length; i++) {
				var obj = {};

				var newidList = idList.eq(i).attr('id');
				// console.log("newidList："+newidList);

				var newObj = orderArr.find(function(fn) {
					// console.log("pro："+fn.pro);
					return fn.pro === newidList
				})

				lpknewarr.push(newObj)
			}
			// console.log(lpknewarr);

			for(var i = 0; i < lpknewarr.length; i++) {

				delete(lpknewarr[i].pro)
			}
			var newobj = JSON.stringify(lpknewarr);
			window.location.href = encodeURI('SureOrder.html?back=0&obj=' + newobj + '&member_id=' + member_id);

		}
		else{
			
			console.log(删除)
			
//			layer.confirm('确定要删除商品吗？', {
//				title: false,
//				closeBtn: false,
//				shade: [0.6],
//				btn: ['确定', "取消"],
//				success: function(layero, index) {
//					$(".layui-layer-btn0").on("click", function() {
//						$.ajax({
//							type: "post",
//							url: "app.php/ShoppingCart/delete",
//							dataType: "json",
//							data: {
//								member_id: 17,
//								id: str
//							},
//							success: function(data) {
//								console.log(data)
//
//								if(data.code == "200") {
//									for(var i = 0; i < list.length; i++) {
//										if(list.eq(i).parents('.bodyItem').find(".product").length === 1) {
//											list.eq(i).parents('.bodyItem').remove();
//										} else {
//											list.eq(i).parents('.product').remove();
//										}
//										koncat();
//									}
//
//									TotalPrice();
//									layer.msg("已删除", {
//										time: 1000
//									}, function() {
//
//										//										window.location.reload();
//									})
//
//								} else {
//									layer.msg(data.msg);
//								}
//
//							}
//						})
//					})
//				},
//				end: function() {
//
//				}
//			})
			
			
			
		}

	}

});

$('#lpkdel').on('click', function() {
	var Text = $(this).text();
	var newarr = [];
	var total = [];
	if(Text == '删除') {
		var list = $('.product-ckb .product-xz');

		for(var i = 0; i < list.length; i++) {
			var listid = list.eq(i).parents('.product').attr('id')
			total.push(listid)
		}
		var str = total.join(',')

		console.log(str)

		if(list.length == 0) {
			layer.confirm('请选择要删除的商品？', {
				title: false,
				closeBtn: false,
				shade: [0.6],
				btn: ['确定']
			})
			//			if(confirm("请选择要删除的商品")) {}
		} else {

			layer.confirm('确定要删除商品吗？', {
				title: false,
				closeBtn: false,
				shade: [0.6],
				btn: ['确定', "取消"],
				success: function(layero, index) {
					$(".layui-layer-btn0").on("click", function() {

						$.ajax({
							type: "post",
							url: "app.php/ShoppingCart/delete",
							dataType: "json",
							data: {
								member_id: 17,
								id: str
							},
							success: function(data) {
								console.log(data)

								if(data.code == "200") {
									for(var i = 0; i < list.length; i++) {
										if(list.eq(i).parents('.bodyItem').find(".product").length === 1) {
											list.eq(i).parents('.bodyItem').remove();
										} else {
											list.eq(i).parents('.product').remove();
										}
										koncat();
									}

									TotalPrice();
									layer.msg("已删除", {
										time: 1000
									}, function() {

										//										window.location.reload();
									})

								} else {
									layer.msg(data.msg);
								}

							}
						})
					})
				},
				end: function() {

				}
			})

		}

	}else{
		
		
		
		
	}

})