<?php 
$orderHelper = \Any\Helper\Order::getInstance();
?>
<div class="wrap">
<div id="poststuff">
    <form method="post">
        <input type="hidden" name="page" value="writing9_manager" >
        
    
    <h1 class="wp-heading-inline">記事パターン一覧</h1>
    <a href="admin.php?page=writing9_manager" class="page-title-action">新規追加</a>
    <hr class="wp-header-end">
    
	
		<hr >
	

<ul class="subsubsub">
	<li class="all"><a href="edit.php?post_type=post" class="current">すべて <span class="count">(2)</span></a> |</li>
	<li class="publish"><a href="edit.php?post_status=publish&amp;post_type=post">依頼済み <span class="count">(1)</span></a> |</li>
	<li class="private"><a href="edit.php?post_status=private&amp;post_type=post">未入金 <span class="count">(1)</span></a></li>
</ul>

	<div class="inside">
		<div id="edit-slug-box" class="hide-if-no-js"></div>
	</div>

    <?php foreach($error->getMessages() as $message):?>
    <div class="error">
    	<p><?php echo $message?></p>
    </div>
    <?php endforeach?>
    
<div id="post-body" class="metabox-holder columns-1">
    
<div id="post-body-content" style="position: relative;"> 



<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
	    <td  id='cb' class='manage-column column-cb check-column'>
		    <label class="screen-reader-text" for="cb-select-all-1">すべて選択</label>
		    <input id="cb-select-all-1" type="checkbox" />
        </td>
	    <th scope="col" id='title' class='manage-column column-title column-primary sortable desc'>
			<a href="https://writing-9-nagoring.c9users.io/wp-admin/edit.php?orderby=title&#038;order=asc">
				<span>タイトル</span>
				<span class="sorting-indicator"></span>
			</a>
		</th>
		<th scope="col" id='author' class='manage-column  column-author'>記事数</th>
		<th scope="col" id='categories' class='manage-column  column-author'>文字数</th>
		<th scope="col" id='date' class='manage-tags sortable asc' style="width:140px;">
			<a href="https://writing-9-nagoring.c9users.io/wp-admin/edit.php?orderby=date&#038;order=desc">
			<span>日時</span><span class="sorting-indicator"></span></a>
		</th>
		<th scope="col" id='tags' class='manage-column sortable asc'><a href="https://writing-9-nagoring.c9users.io/wp-admin/edit.php?orderby=date&#038;order=desc"><span>状態</span><span class="sorting-indicator"></span></a></th>
		
		
	</tr>
	</thead>
	<tbody>
	
	<?php foreach($orders as $order):?>
	<?php $orderHelper->init($order)?>
	<tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
			<th scope="row" class="check-column">
				<label class="screen-reader-text" for="cb-select-1">Hello world!を選択</label>
			<input id="cb-select-1" type="checkbox" name="post[]" value="1">
			<div class="locked-indicator">
				<span class="locked-indicator-icon" aria-hidden="true"></span>
				<span class="screen-reader-text">ロックされています。</span>
			</div>
		</th>
		
		<td class="title column-title has-row-actions column-primary page-title" data-colname="タイトル">
			<div class="locked-info"><span class="locked-avatar"></span>
			<span class="locked-text"></span></div>
		<strong><a class="row-title" href="#" aria-label="<?php echo $orderHelper->listTitle()?>の詳細"><?php echo $orderHelper->listTitle()?></a></strong>
	<div class="row-actions">
		<span class="edit"><a href="#" aria-label="<?php echo $orderHelper->listTitle()?>の詳細">詳細</a></span>
	</div>
		</td>
		<td class="author column-author"><?php echo $orderHelper->number_articles()?><small>記事</small></td>
		<td class="categories column-categories"><?php echo $orderHelper->word_count()?><small>文字</small></td>
		<td><?php echo $orderHelper->status()?><br><abbr title="<?php echo $orderHelper->post_date()?>"><?php echo $orderHelper->post_date()?></abbr></td>
		<td class="tags column-tags">
			<!--<label ><progress value="50" max="100"><span>50</span>%</progress><br><?php echo $orderHelper->status()?>-->
			<form method="post" action="<?php echo get_admin_url() . 'admin.php?page=writing9_order'?>">
				<input type="hidden" name="order_id" value="<?php echo $orderHelper->id()?>">
			<?php echo $orderHelper->submitTag()?>
			</form>
		</td>
	</tr>
	<?php endforeach?>
		
		
		
		
		
		<tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
		<th scope="row" class="check-column"><label class="screen-reader-text" for="cb-select-1">Hello world!を選択</label>
		</th>
		<td class="title column-title has-row-actions column-primary page-title" data-colname="タイトル">
			<div class="locked-info">
				<span class="locked-avatar"></span>
				<span class="locked-text"></span>
			</div>
			
<strong><a class="row-title" href="https://writing-9-nagoring.c9users.io/wp-admin/post.php?post=1&amp;action=edit" aria-label="「Hello world!」 (編集)">コスメ,トラブル,ビタミンC,対策方法</a></strong>

<div class="hidden" id="inline_1">
	<div class="post_title">Hello world!</div><div class="post_name">hello-world</div>
	<div class="post_author">1</div>
	<div class="comment_status">open</div>
	<div class="ping_status">open</div>
	<div class="_status">publish</div>
	<div class="jj">21</div>
	<div class="mm">01</div>
	<div class="aa">2017</div>
	<div class="hh">09</div>
	<div class="mn">02</div>
	<div class="ss">03</div>
	<div class="post_password"></div>
	<div class="page_template">default</div><div class="post_category" id="category_1">1</div><div class="tags_input" id="post_tag_1"></div>
	<div class="sticky"></div>
	<div class="post_format"></div>
	</div>
	<div class="row-actions">
		<span class="edit"><a href="https://writing-9-nagoring.c9users.io/wp-admin/post.php?post=1&amp;action=edit" aria-label="“Hello world!” を編集する">編集</a>
	| </span><span class="trash">
		<a href="https://writing-9-nagoring.c9users.io/wp-admin/post.php?post=1&amp;action=trash&amp;_wpnonce=c34e8e5d85" class="submitdelete" aria-label="「Hello world!」をゴミ箱に移動">ゴミ箱へ移動</a> | </span>
		<span class="view"><a href="https://writing-9-nagoring.c9users.io/index.php/2017/01/21/hello-world/" rel="permalink" aria-label="複製">複製</a></span></div>
		<button type="button" class="toggle-row"><span class="screen-reader-text">詳細を追加表示</span></button></td>
		<td class="author column-author">5<small>記事</small></td>
		<td class="categories column-categories">800<small>文字</small></td>
		<td><abbr title="2017年01月21日 am 9:02:03">2017年1月21日</abbr></td>
		<td class="tags column-tags"><input name="save" type="submit" class="button button-primary button-large" id="publish" value="未入金"></td>
		</tr>
		<tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
			<th scope="row" class="check-column">			<label class="screen-reader-text" for="cb-select-1">Hello world!を選択</label>
			<input id="cb-select-1" type="checkbox" name="post[]" value="1">
			<div class="locked-indicator">
				<span class="locked-indicator-icon" aria-hidden="true"></span>
				<span class="screen-reader-text">“Hello world!”はロックされています。</span>
			</div>
		</th><td class="title column-title has-row-actions column-primary page-title" data-colname="タイトル">
			<div class="locked-info"><span class="locked-avatar"></span>
			<span class="locked-text"></span></div>
<strong><a class="row-title" href="https://writing-9-nagoring.c9users.io/wp-admin/post.php?post=1&amp;action=edit" aria-label="「Hello world!」 (編集)">アトピー,対策,体験談,口コミ</a></strong>

<div class="hidden" id="inline_1">
	<div class="post_title">Hello world!</div><div class="post_name">hello-world</div>
	<div class="post_author">1</div>
	<div class="comment_status">open</div>
	<div class="ping_status">open</div>
	<div class="_status">publish</div>
	<div class="jj">21</div>
	<div class="mm">01</div>
	<div class="aa">2017</div>
	<div class="hh">09</div>
	<div class="mn">02</div>
	<div class="ss">03</div>
	<div class="post_password"></div>
	<div class="page_template">default</div><div class="post_category" id="category_1">1</div><div class="tags_input" id="post_tag_1"></div>
	<div class="sticky"></div>
	<div class="post_format"></div>
	</div>
	<div class="row-actions">
		<span class="edit"><a href="https://writing-9-nagoring.c9users.io/wp-admin/post.php?post=1&amp;action=edit" aria-label="“Hello world!” を編集する">編集</a>
	| </span><span class="trash">
		<a href="https://writing-9-nagoring.c9users.io/wp-admin/post.php?post=1&amp;action=trash&amp;_wpnonce=c34e8e5d85" class="submitdelete" aria-label="「Hello world!」をゴミ箱に移動">ゴミ箱へ移動</a> | </span>
		<span class="view"><a href="https://writing-9-nagoring.c9users.io/index.php/2017/01/21/hello-world/" rel="permalink" aria-label="複製">複製</a></span></div>
		<button type="button" class="toggle-row"><span class="screen-reader-text">詳細を追加表示</span></button></td>
		<td class="author column-author">20<small>記事</small></td>
		<td class="categories column-categories">200<small>文字</small></td>
		<td>入金済み<br><abbr title="2017年01月21日 am 9:02:03">2017年1月21日</abbr></td>
		<td class="tags column-tags"><label ><progress value="80" max="100"><span>80</span>%</progress><br>記事作成中</td>

		</tr>
	</tbody>
</table>

<div id="pageparentdiv" class="postbox">
	<div class="inside">
		<p>［ご注意］writing-9は、WordPressからの記事の発注と管理・投稿を簡略化させるために作られたプラグインです。ライターはキーワードにあわせて良い記事を書けるよう尽力いたしますが、記事作成後の取り下げ、入金後のキャンセルは出来ませんので、ご了承ください。</p>
	</div>
</div>
<div class="tablenav bottom">

	<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-bottom" class="screen-reader-text">一括操作を選択</label><select name="action2" id="bulk-action-selector-bottom">
	<option value="-1">一括操作</option>
	<option value="payment">一括決済</option>
	<option value="edit" class="hide-if-no-js">編集</option>
	<option value="trash">ゴミ箱へ移動</option>
</select>
<input type="submit" id="doaction2" class="button action" value="適用">
		</div>
				<div class="alignleft actions">
		</div>
<div class="tablenav-pages one-page"><span class="displaying-num">2個の項目</span>
<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
<span class="screen-reader-text">現在のページ</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">1 / <span class="total-pages">1</span></span></span>
<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
<span class="tablenav-pages-navspan" aria-hidden="true">»</span></span></div>
		<br class="clear">
	</div>
	
<!-- memo：記事をコピーして新規パターンを作成するボタンが必要かもだ-->
<!-- memo：複製のリンクをつけました-->
    
	</div><!--post-body-content-->
</div><!--post-body-->

	</form>	
</div><!--#poststuff-->
</div><!--.wrap-->
