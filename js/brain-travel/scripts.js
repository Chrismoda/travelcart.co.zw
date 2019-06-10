$(document).ready(function(){
        $('.check').click(function(){
          event.preventDefault();

			var sy = document.getElementById("symptom").value;
			let trainedNet;

			function encode(arg) {
				return arg.split('').map(x => (x.charCodeAt(0) / 256));
			}

			function processTrainingData(data) {
				return data.map(d => {
					return {
						input: encode(d.input),
						output: d.output
					}
				})
			}

			function train(data) {
				let net = new brain.NeuralNetwork();
				net.train(processTrainingData(data));
				trainedNet = net.toFunction();
			};

			 function execute(input) {
				let results = trainedNet(encode(input));
				console.log(results)
				let output;
				let certainty;
				if (results.cholera > results.typhoid) {
					output = 'Cholera'
					certainty = Math.floor(results.cholera * 100)
				} else { 
					output = 'Typhoid'
					certainty = Math.floor(results.typhoid * 100)
				}

				return "I'm " + certainty + "% sure that the disease is " + output;
			}

			train(trainingData);
			$('#response').html(execute(sy));
			document.getElementById("checkForm").reset();
		});
});
