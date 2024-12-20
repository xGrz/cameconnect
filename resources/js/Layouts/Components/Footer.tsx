import {BottomNavigation, BottomNavigationAction} from "@mui/material";
import {Home, Language, Settings} from "@mui/icons-material";
import React from "react";

export default function Footer() {
    const [value, setValue] = React.useState(0);


    return (
        <BottomNavigation
            value={value}
            onChange={(event, newValue) => {
                setValue(newValue);
            }}
        >
            <BottomNavigationAction label="Start" icon={<Home/>}/>
            <BottomNavigationAction label="Sites" icon={<Language/>}/>
            <BottomNavigationAction label="Settings" icon={<Settings/>}/>
        </BottomNavigation>
    );

}
