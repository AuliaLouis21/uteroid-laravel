<table sytle="float:left;">
	<? foreach($query->result_array() as $row) : ?>
		<tr>
			<td><?= checkbox_tag(array('id'=>'cb_'.$row['no_id'],'name'=>'cb_account[]'),array($row['no_id']=>$row['code'])) ?></td>
			<td><div style='margin-left:100px'><?= label_for($row['account']) ?></div></td>
		</tr>
	<? endforeach ?>
</table>