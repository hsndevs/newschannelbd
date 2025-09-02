import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { useSelect, useDispatch } from '@wordpress/data';
import { PanelBody, RadioControl, Spinner } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';

const TAXONOMY = 'report_by';

const ReportBySingleSelectPanel = () => {
	const [terms, setTerms] = useState([]);
	const [loading, setLoading] = useState(true);

	const postId = useSelect((select) => select('core/editor').getCurrentPostId(), []);
	const selectedTerm = useSelect((select) => {
		const terms = select('core/editor').getEditedPostAttribute('taxonomies')?.[TAXONOMY];
		return terms && terms.length ? terms[0] : '';
	}, []);
	const { editPost } = useDispatch('core/editor');

	useEffect(() => {
		wp.apiFetch({ path: `/wp/v2/${TAXONOMY}?per_page=100` }).then((data) => {
			setTerms(data);
			setLoading(false);
		});
	}, []);

	if (loading) return <PanelBody title="Report By"><Spinner /></PanelBody>;

	return (
		<PluginDocumentSettingPanel
			name="report-by-single-select"
			title="Report By (Single)"
			className="report-by-single-select-panel"
		>
			<RadioControl
				label="Select Reporter"
				selected={selectedTerm}
				options={terms.map((term) => ({ label: term.name, value: term.id }))}
				onChange={(termId) => {
					editPost({ taxonomies: { [TAXONOMY]: termId ? [parseInt(termId)] : [] } });
				}}
			/>
		</PluginDocumentSettingPanel>
	);
};

registerPlugin('report-by-single-select', {
	render: ReportBySingleSelectPanel,
	icon: null,
});
