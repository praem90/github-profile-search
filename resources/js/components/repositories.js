import React, {useEffect, useState} from 'react';
import SearchBar from './search';
import RepoItem from './repo-item';
import axios from 'axios';
import Empty from './empty';

const RepoList = props => {
	const [repos, setRepos] = useState([]);

	const onChange = e => {
		setRepos(props.repos.filter(repo => repo.name.indexOf(e.target.value) > -1));
	}

	const fetchRepos = () => {
		axios.get('/profile/' + props.profile_id + '/repos').then(res => {
			setRepos(res.data.data);
		});
	}

	useEffect(fetchRepos,  [props.profile_id]);

	return (
		<div className="bg-white overflow-hidden sm:rounded-md ">
		  <SearchBar onChange={_.debounce(onChange, 500)}  searchOnly={true} />
    	  <ul role="list" className="divide-y divide-gray-200">
    		{repos.map((repo, i) => {
    			return <RepoItem key={i} repo={repo} />
    		})}
    		{repos.length === 0 ? <Empty title="No Repositories found" description="" /> : ''}
		  </ul>
		</div>
	)
}

export default RepoList


