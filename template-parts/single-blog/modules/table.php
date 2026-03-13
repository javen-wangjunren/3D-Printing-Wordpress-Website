<?php
/**
 * Module: Table (CSV-based)
 */

$caption = get_sub_field( 'table_caption' );
$csv_data = get_sub_field( 'table_data' );

if ( empty( $csv_data ) ) {
	return;
}

$csv_data = trim( $csv_data );
$lines = explode( "\n", $csv_data );

if ( empty( $lines ) ) {
	return;
}

$table_data = array();
foreach ( $lines as $line ) {
	$table_data[] = str_getcsv( trim( $line ), ',', '"' );
}

if ( empty( $table_data ) ) {
	return;
}

$headers = $table_data[0];
$body = array_slice( $table_data, 1 );

?>
<div class="my-8 overflow-hidden border border-border rounded-card">
	<div class="overflow-x-auto">
		<table class="w-full text-sm text-left">
			<?php if ( $caption ) : ?>
				<caption class="p-4 text-xs font-bold uppercase tracking-wider text-heading/70 bg-panel border-b border-border text-left">
					<?php echo esc_html( $caption ); ?>
				</caption>
			<?php endif; ?>
			
			<?php if ( $headers ) : ?>
				<thead class="text-xs text-heading uppercase bg-bg-section font-bold">
					<tr>
						<?php foreach ( $headers as $header ) : ?>
							<th scope="col" class="px-6 py-4 whitespace-nowrap border-b border-border">
								<?php echo esc_html( trim( $header ) ); ?>
							</th>
						<?php endforeach; ?>
					</tr>
				</thead>
			<?php endif; ?>

			<tbody>
				<?php foreach ( $body as $row ) : ?>
					<tr class="bg-white border-b border-border last:border-0 hover:bg-panel transition-colors">
						<?php foreach ( $row as $cell ) : ?>
							<td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
								<?php echo esc_html( trim( $cell ) ); ?>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
