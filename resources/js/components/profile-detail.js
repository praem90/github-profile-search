import React, {useEffect, useState} from 'react';
import RepoList from './repositories';

export default props => {
	const [details, setDetails] = useState({});

	useEffect(() => {
		axios.get('/profile/'+props.selected.login).then(res => {
			setDetails(res.data);
		}).catch(() => {
			props.onClose();
		});
	}, []);

	return (
		<div className={"fixed inset-0 overflow-hidden z-50 " + (props.selected ? '' : 'hidden')} aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
  	  	  <div className="absolute inset-0 overflow-hidden">
    		<div className={"absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity ease-in-out duration-500 " + ( props.selected ? '': 'opacity-0')} aria-hidden="true"></div>
    		<div className={"fixed inset-y-0 right-0 pl-10 max-w-6xl flex transform transition ease-in-out duration-500 sm:duration-700 " + (props.selected ? '' : 'translate-x-full')}>
      	  	  <div className="relative w-screen max-w-md">
        		<div className="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
          	  	  <button onClick={props.onClose} type="button" className="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
            		<span className="sr-only">Close panel</span>
            		<svg className="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              	  	  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
            		</svg>
          	  	  </button>
        		</div>
        		{details ? <PanelBody key={details.id} details={details} /> : ''}
      	  	  </div>
    		</div>
  	  	  </div>
		</div>
	)
}

const PanelBody = props => (
	<div className="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll">
      <div className="px-4 sm:px-6">
        <h2 className="text-lg font-medium text-gray-900" id="slide-over-title">
        	{props.details.detail?.name}
        </h2>
      </div>
      <div className="mt-6 relative flex-1 px-4 sm:px-6">
        <div className="absolute inset-0 px-4 sm:px-6">
    		<div className="h-full " aria-hidden="true">
    			<div className="flex">
    				<img className="w-48 rounded-md" src={props.details?.avatar_url} />
    				<div className="pl-3">
    					<p><span className="text-sm">{props.details?.login}</span></p>
    					<p><span className="text-sm">{props.details?.detail?.email}</span></p>
    					<p><span className="text-sm">{props.details?.detail?.location}</span></p>
    					<p><span className="text-sm">{props.details?.detail?.created_at}</span></p>
    					<p>
    						<span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
    							Followers {props.details.followers}
    						</span>
    						<span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
    							Following {props.details.detail?.following}
    						</span>
    						<span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
    							Repo Count {props.details.public_repos}
    						</span>
    						<span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
    							View Count {props.details.view_count}
    						</span>
    					</p>
    				</div>
    			</div>
    			<div className="w-full mt-3">
    				<p>{props.details.detail?.bio}</p>
    			</div>
    			<div className="w-full mt-3">
    				<RepoList profile_id={props.details.id} />
    			</div>
    		</div>
        </div>
      </div>
      </div>
)
