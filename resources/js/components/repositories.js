import React, {useState} from 'react';
import SearchBar from './search';
import RepoItem from './repo-item';

const RepoList = props => {
	const [repos, setRepos] = useState(props.repos);

	const onChange = e => {
		setRepos(props.repos.filter(repo => repo.name.indexOf(e.target.value) > -1));
	}

	return (
		<div className="bg-white shadow overflow-hidden sm:rounded-md">
		  <SearchBar onChange={_.debounce(onChange, 500)}  />
    	  <ul role="list" className="divide-y divide-gray-200">
    		{repos.map((repo, i) => {
    			return <RepoItem key={i} repo={repo} />
    		})}
		  </ul>
		</div>
	)
}

export default RepoList


