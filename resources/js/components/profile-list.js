import React, {useState} from 'react';
import ProfileListItem from './profile-list-item';
import ProfileDetail from './profile-detail';

const ProfileList = props => {
	const [selected, setSelected] = useState(null);

	return (
		<div className="bg-white shadow overflow-hidden sm:rounded-md">
    	  <ul role="list" className="divide-y divide-gray-200">
    		{props.profiles.map((profile, i) => {
    			return <ProfileListItem onClick={() => setSelected(profile)} key={i} profile={profile} />
    		})}
		  </ul>
		{selected ? <ProfileDetail selected={selected} onClose={() => setSelected(null)} /> : ''}
		</div>
	)
}

export default ProfileList

