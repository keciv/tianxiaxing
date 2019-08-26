function loadMore(parentObj, itemObj, resultItem, url) {
			var counter = 0;
			var num = 3;
			var pageStart = 0,
				pageEnd = 0;
			parentObj.dropload({
				scrollArea: window,
				domDown: {
					domNoData: '<p class="dropload-noData">没有数据了</p>',
				},
				loadDownFn: function(me) {
					$.ajax({
						type: 'GET',
						url: url,
						dataType: 'json',
						success: function(data) {
							var result = '';
							counter++;
							pageEnd = num * counter;
							pageStart = pageEnd - num;
							for(var i = pageStart; i < pageEnd; i++) {
								result += resultItem(data, i);
								if((i + 1) >= data.lists.length) {
									// 锁定
									me.lock();
									// 无数据
									me.noData();
									break;
								}
							}
							setTimeout(function() {
								itemObj.append(result);
								me.resetload();
							}, 1000);

						},
						error: function(xhr, type) {
							alert('Ajax error!');
							me.resetload();
						}
					});
				}
			});
		}