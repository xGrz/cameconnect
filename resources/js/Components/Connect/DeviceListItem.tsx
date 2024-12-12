import {Button, List, ListItem, ListItemText} from "@mui/material";
import {ICommand, IDevice} from "@/types/inertia";
import DeviceIcon from "@/Components/Connect/DeviceIcon";
import {useState} from "react";
import {router} from "@inertiajs/react";
import {blue} from "@mui/material/colors";

interface DeviceListItemProps {
    device: IDevice;
    level?: number;
}


export default function DeviceListItem({device, level = 1}: DeviceListItemProps) {
    const [disabled, setDisabled] = useState(false)

    function handleCommand(command: ICommand) {
        const url = '/device/' + device.id + '/command/' + command.commandId;
        const data = { device: device.id, command: command.commandId };

        router.post(url, data);
        // setDisabled(true)
        // fetch(url, {
        //     method: "POST",
        //     headers: {
        //         "Content-Type": "application/json", // Specify the content type
        //     },
        //     body: JSON.stringify(data), // Convert data to JSON string
        // })
        //     .then((response) => {
        //         if (!response.ok) {
        //             throw new Error("Network response was not ok");
        //         }
        //         return response.json(); // Parse the response as JSON
        //     })
        //     .then((data) => {
        //         console.log("Success:", data); // Handle the response data
        //         setDisabled(false)
        //     })
        //     .catch((error) => {
        //         console.error("Error:", error); // Handle errors
        //         setDisabled(false)
        //     });
    }


    return (
        <>
            <ListItem sx={{paddingLeft: level * 3, backgroundColor: blue[600]}}>
                <DeviceIcon iconName={device.iconName} online={device.status.online}/>
                <ListItemText secondary={device.id + ' ' + device.modelId} sx={{marginLeft: 2}}>
                    {device.name}
                </ListItemText>
                <div>
                    {device.commands && device.commands.map((command, idx) => (
                        <Button key={idx} variant="contained" size="small" onClick={() => handleCommand(command)} disabled={disabled}>
                            {command.label}
                        </Button>
                    ))}
                </div>
            </ListItem>
            {device.devices.length > 0 && (
                <List>
                    {device.devices.map((device) => (
                        <DeviceListItem device={device} level={level + 1} key={device.id}/>
                    ))}
                </List>
            )}
        </>
    )
}
