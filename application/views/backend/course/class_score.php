<div class="x_content">
	<div class="table-responsive">
		<?php if ($rows) { ?>
		<table class="table table-striped jambo_table table-bordered">
			<thead id="checkbox_all">
				<tr class="headings">
					<th class="column-title">Tên bài test</th>
					<th class="column-title">Tên học viên</th>
					<th class="column-title">Email học viên</th>
					<th class="column-title">Điểm số</th>
					<th class="column-title">Thời gian làm bài</th>
					<th class="column-title">Xem lại bài làm</th>
				</tr>
			</thead>
			<tbody id="checkbox_list">
				<?php foreach ($rows as $key => $row) { ?>
				<tr>
					<td>
						<?php echo $row['test_title']; ?>
					</td>
					<td><?php echo $row['fullname'] ? : $row['email']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><?php echo $row['score']; ?></td>
					<td><?php echo date('H:i d/m/Y', $row['start_time']); ?></td>
					<td>
						<a href="/test/review_result/<?php echo $row['logs_id']; ?>/<?php echo $this->security->generate_token_post($row['logs_id']); ?>" title="<?php echo $row['title']; ?>" target="_blank">
							Click để xem
						</a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php }else{?>
		<div class="no-result"><?php echo $this->lang->line("common_no_result"); ?></div>
		<?php } ?>
	</div>
</div>